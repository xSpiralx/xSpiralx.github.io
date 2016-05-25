<?php

class Tesla_categories_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_categories',
                'Tesla - Categories',
                array(
            'description' => __('A list of categories', 'teslawp'),
            'classname' => 'widget_teslawp_categories',
                )
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Categories','teslawp') : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        ?>
        <ul>
            <?php
            $cat_args['title_li'] = '';
            wp_list_categories(apply_filters('widget_teslawp_categories_args', $cat_args));
            ?>
        </ul>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = esc_attr($instance['title']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','teslawp'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

}