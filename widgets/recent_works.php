<?php

class Tesla_recent_works_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_recent_works',
                'Tesla - Recent Works',
                array(
            'description' => __('A list of recent works', 'teslawp'),
            'classname' => 'widget_teslawp_recent_works',
                )
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Works','teslawp') : $instance['title'], $instance, $this->id_base);
        $category = $instance['category'];

        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        ?>
        <div class="widgetWorks">
            <?php
            if(isset($instance['category'])&&$instance['category']!==''){
                $cat_args['title_li'] = '';
                $args = array(
                    'numberposts' => $instance['number'],
                    'category' => $instance['category'],
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'meta_key' => '_thumbnail_id',
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'suppress_filters' => true
                );
                $query = get_posts($args);
                foreach($query as $q){
                    echo '<div class="widgetWorksEntry">';
                    echo '<div class="widgetWorksEntryImg">';
                    echo '<a href="'.get_permalink($q->ID).'">';
                    echo '<span></span>';
                    echo get_the_post_thumbnail($q->ID);
                    echo '</a>';
                    echo '</div>';
                    echo '<div class="widgetWorksEntryInfo">';
                    echo $q->post_excerpt;
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = $new_instance['category']===''?NULL:(int)strip_tags($new_instance['category']);
        $instance['number'] = (int)strip_tags($new_instance['number']);

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'category' => ''));
        $title = esc_attr($instance['title']);
        $category = esc_attr($instance['category']);
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','teslawp'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of works to show:','teslawp'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
        </p>
        <p>
            <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
                <?php
                $term = term_exists($instance['category'], 'category');
                if ($instance['category'] === '' || $term === 0 || $term === null)
                    echo '<option value=""> - Choose a category - </option>';
                $cats = get_categories();
                foreach ($cats as $c) {
                    $option = '<option value="' . $c->cat_ID . '"' . selected($instance['category'], $c->cat_ID, false) . '>';
                    $option .= $c->cat_name;
                    $option .= '</option>';
                    echo $option;
                }
                ?>
            </select>
        </p>
        <?php
    }

}