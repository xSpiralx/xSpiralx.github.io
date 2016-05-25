<?php

return array(
        'favico' => array(
                'dir' => '/images/favicon.png'
        ),
        'option_saved_text' => _x('Options successfully saved','admin','teslawp'),
        'tabs' => array(
                array(
                        'title'=>_x('General Options','admin','teslawp'),
                        'icon'=>1,
                        'boxes' => array(
                                _x('Logo Customization','admin','teslawp') => array(
                                        'icon'=>'customization',
                                        'size'=>'2_3',
                                        'columns'=>true,
                                        'description'=>_x('Here you upload a image as logo or you can write it as text and select the logo color, size, font.','admin','teslawp'),
                                        'input_fields' => array(
                                                _x('Logo As Image','admin','teslawp')=>array(
                                                        'size'=>'half',
                                                        'id'=>'logo_image',
                                                        'type'=>'image_upload',
                                                        'note'=>_x('Here you can insert your link to a image logo or upload a new logo image.','admin','teslawp')
                                                ),
                                                _x('Logo As Text','admin','teslawp')=>array(
                                                        'size'=>'half_last',
                                                        'id'=>'logo_text',
                                                        'type'=>'text',
                                                        'note' => _x("Type the logo text here, then select a color, set a size and font",'admin','teslawp'),
                                                        'color_changer'=>true,
                                                        'font_changer'=>true,
                                                        'font_size_changer'=>array(1,1000, 'px'),
                                                        'font_preview'=>array(true, true)
                                                )
                                        )
                                ),
                                _x('Favicon','admin','teslawp') => array(
                                        'icon'=>'customization',
                                        'size'=>'1_3_last',
                                        'input_fields' => array(
                                                array(
                                                        'id'=>'favicon',
                                                        'type'=>'image_upload',
                                                        'note'=>_x('Here you can upload the favicon icon.','admin','teslawp')
                                                )
                                        )
                                ),
                                _x('Custom CSS','admin','teslawp') => array(
                                        'icon'=>'css',
                                        'size'=>'2_3',
                                        'description'=>_x('Here you can write your personal CSS for customizing the classes you choose to modify.','admin','teslawp'),
                                        'input_fields' => array(
                                                array(
                                                        'id'=>'custom_css',
                                                        'type'=>'textarea'
                                                )
                                        )
                                ),
                                _x('Site Color','admin','teslawp') => array(
                                        'icon'=>'background',
                                        'size'=>'1_3_last',
                                        'input_fields' => array(
                                                array(
                                                        'size'=>'7',
                                                        'id'=>'site_color',
                                                        'type'=>'colorpicker',
                                                        'note'=>_x('Change the default color of the site.','admin','teslawp')
                                                )
                                        )
                                )
                        )
                ),
                array(
                        'title' => _x('Additional Options','admin','teslawp'),
                        'icon'  => 6,
                        'boxes' => array(
                                _x('Social Platforms','admin','teslawp')=>array(
                                        'icon'=>'social',
                                        'description'=>_x("Insert the link to the social share page.",'admin','teslawp'),
                                        'size'=>'1_3',
                                        'columns'=>true,
                                        'input_fields'=>array(
                                                array(
                                                        'id'=>'social_platforms',
                                                        'size'=>'half',
                                                        'type'=>'social_platforms',
                                                        'platforms'=>array('facebook','twitter','google','pinterest','linkedin','dribbble','behance','youtube','flickr')
                                                )
                                        )
                                ),
                                _x('Blog Options','admin','teslawp')=>array(
                                        'icon' => 'customization',
                                        'size'=>'1_3',
                                        'columns'=>true,
                                        'input_fields' =>array(
                                                _x('Blog Page Title','admin','teslawp') => array(
                                                        'id'    => 'blog_title',
                                                        'type'  => 'text',
                                                        'note' => _x('Give another title for the blog page','admin','teslawp'),
                                                        'size' => 'half',
                                                        'placeholder' => _x('Ex: News, Updates, Events etc.','admin','teslawp')
                                                )
                                        )
                                ),
                                _x('Append to footer','admin','teslawp') => array(
                                        'icon'=>'track',
                                        'size'=>'1_3_last',
                                        'input_fields'=>array(
                                                array(
                                                        'type'=>'textarea',
                                                        'id'=>'append_to_footer'
                                                )
                                        )
                                )
                        )
                )
        ),
        'styles' => array( array('wp-color-picker'),'style','select2' )
        ,
        'scripts' => array( array( 'jquery', 'jquery-ui-core','jquery-ui-datepicker','wp-color-picker' ), 'select2.min','jquery.cookie','tt_options', 'admin_js' )
);