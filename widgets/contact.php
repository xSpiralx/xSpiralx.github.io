<?php 

class Tesla_contact_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_contact',
                'Tesla - Contact',
                array(
            'description' => __('Contact details', 'teslawp'),
            'classname' => 'widget_teslawp_contact',
                ),
                array('width' => 400, 'height' => 350)
        );
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __('Contact','teslawp') : $instance['title'], $instance, $this->id_base );
        $company = empty( $instance['company'] ) ? 'Company' : $instance['company'];
        $text = empty( $instance['text'] ) ? "Address\nCity, State Zip\n+123 456 7890\n+123 456 7890\nemail@address.com" : $instance['text'];
        echo $before_widget;
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
            <div class="widgetBody">
                <div class="widgetAddress">
                    <div class="widgetAddressCompany"><?php echo $company; ?></div>
                    <?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
                </div>
            </div>
        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['company'] = strip_tags($new_instance['company']);
        if ( current_user_can('unfiltered_html') )
            $instance['text'] =  $new_instance['text'];
        else
            $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );
        $instance['filter'] = isset($new_instance['filter']);
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => 'Contact', 'text' => "Address\nCity, State Zip\n+123 456 7890\n+123 456 7890\nemail@address.com", 'company' => 'Company', 'filter' => 1 ) );
        $title = strip_tags($instance['title']);
        $text = esc_textarea($instance['text']);
        $company = strip_tags($instance['company']);
        $filter = $instance['filter'];
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','teslawp'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('company'); ?>"><?php _e('Company:','teslawp'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('company'); ?>" name="<?php echo $this->get_field_name('company'); ?>" type="text" value="<?php echo esc_attr($company); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Contact details:','teslawp'); ?></label>
            <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea($text); ?></textarea>
        </p>

        <p>
            <input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked($filter); ?> />&nbsp;
            <label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add line breaks','teslawp'); ?></label>
        </p>
<?php
    }

}