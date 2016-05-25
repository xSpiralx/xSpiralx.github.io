<?php 
class Tesla_flickr_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_flickr',
                'Tesla - Flickr',
                array(
            'description' => __('A list of Flickr images', 'teslawp'),
            'classname' => 'widget_teslawp_flickr',
                )
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Flickr widget','teslawp') : $instance['title'], $instance, $this->id_base);
        $user = empty($instance['user']) ? '97073871@N04' : $instance['user'];
        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 12;

        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        ?>
        <div class="widgetBody widgetFlickr" data-user="<?php echo $user; ?>" data-images="<?php echo $number; ?>"></div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['user'] = strip_tags($new_instance['user']);
        $instance['number'] = (int)strip_tags($new_instance['number']);

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $user = isset($instance['user']) ? esc_attr($instance['user']) : '97073871@N04';
        $number = isset($instance['number']) ? absint($instance['number']) : 12;
        ?>
        <p>
            <label><?php _e('Title:','teslawp'); ?><input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label> 
            <label><?php _e('Flickr user id:','teslawp'); ?><input class="widefat" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo esc_attr($user); ?>" /></label> 
            <label for="<?php echo $this->get_field_id('number'); ?>">
                <?php _e('Number of posts to show:','teslawp'); ?>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
            </label>
        </p>
        <?php
    }

}