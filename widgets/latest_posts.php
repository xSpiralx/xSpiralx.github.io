<?php
class Tesla_latest_posts_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_latest_posts',
                'Tesla - Latest Posts',
                array(
            'description' => __('A list of the latest posts', 'teslawp'),
            'classname' => 'widget_teslawp_latest_posts',
                )
        );
        $this->alt_option_name = 'widget_teslawp_latest_posts_entries';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_teslawp_latest_posts_cache', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset($args['widget_id']))
            $args['widget_id'] = $this->id;

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Latest Posts','teslawp') : $instance['title'], $instance, $this->id_base);
        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 10;

        $r = new WP_Query(apply_filters('widget_posts_args', array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true)));
        if ($r->have_posts()) :
            ?>
            <?php echo $before_widget; ?>
            <?php if ($title) echo $before_title . $title . $after_title; ?>
            <?php if($args['id']==='footer-sidebar'): ?>
                <div class="widgetBody widgetPosts">
                    <?php 
                    while ($r->have_posts()) : $r->the_post(); ?>
                        <div class="widgetPostsEntry">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="widgetPostsEntryAvatar">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                            <?php endif; ?>
                            <div class="widgetPostsEntryBody">
                                <div class="widgetPostsEntryBodyTitle">
                                    <a class="textcolor7" href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                                <div class="widgetPostsEntryBodyText">
                                    <?php echo get_the_excerpt().'&nbsp;<a class="widgetPostsEntryBodyTextMore bgcolor" href="'.get_permalink().'"></a>'; ?>
                                </div>
                            </div>
                        </div>
                        <?php if($r->have_posts()): ?>
                            <div class="widgetPostsEntryDelimiter"></div>
                        <?php else: break; endif; ?>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
            <ul>
                <?php while ($r->have_posts()) : $r->the_post(); ?>
                    <li>
                        <span class="post-date"><?php echo get_the_date('d M'); ?></span>
                        <a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php
                            if (get_the_title())
                                the_title();
                            else
                                the_ID();
                            ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php endif; ?>
            <?php echo $after_widget; ?>
            <?php
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_teslawp_latest_posts_cache', $cache, 'widget');
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['widget_teslawp_latest_posts_entries']))
            delete_option('widget_teslawp_latest_posts_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_teslawp_latest_posts_cache', 'widget');
    }

    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','teslawp'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:','teslawp'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
        </p>
        <?php
    }

}