<?php

/*============================== TESLA FRAMEWORK ======================================================================================================================*/

require_once(get_template_directory() . '/tesla_framework/tesla.php');



/*============================== THEME FEATURES ======================================================================================================================*/

function teslawp_theme_features() {

    register_nav_menus(array(
        'teslawp_menu' => 'Tesla Header Menu'
    ));

    if (!isset($content_width))
        $content_width = 960;

    add_theme_support('post-thumbnails');

    add_theme_support( 'custom-background' );

    add_theme_support( 'automatic-feed-links' );
}

add_action('after_setup_theme', 'teslawp_theme_features');

function teslawp_widgets_init(){

    register_sidebar(array(
        'name' => 'Blog Sidebar',
        'id' => 'blog-sidebar',
        'description' => 'This sidebar is located on the left side of the content on the blog page.',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s font2">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widgetTitle font1 widgettitle">',
        'after_title' => '</div>'
    ));
    register_sidebar(array(
        'name' => 'Footer Sidebar',
        'id' => 'footer-sidebar',
        'description' => 'This sidebar is located in the footer area of the blog page.',
        'class' => '',
        'before_widget' => '<div class="footerColumn"><div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<div class="titleContainer titleFooter font1 widgettitle"><div class="title">',
        'after_title' => '</div></div>'
    ));
    register_sidebar(array(
        'name' => 'Page Sidebar',
        'id' => 'page-sidebar',
        'description' => 'This sidebar is located on the left side of the content on user created pages. This is the default sidebar for pages.',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s font2">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widgetTitle font1 widgettitle">',
        'after_title' => '</div>'
    ));

    for($i=1;$i<=10;$i++)
        register_sidebar(array(
            'name' => 'Alternative Sidebar #'.$i,
            'id' => 'alt-sidebar-'.$i,
            'description' => 'This sidebar is can be chosen as an alternative for Page Sidebar.',
            'class' => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s font2">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widgetTitle font1 widgettitle">',
            'after_title' => '</div>'
        ));

}

add_action('widgets_init', 'teslawp_widgets_init');



/*============================== LANGUAGE SETUP ======================================================================================================================*/

function teslawp_theme_setup(){
    load_theme_textdomain('teslawp', get_template_directory() . '/language');
}
add_action('after_setup_theme', 'teslawp_theme_setup');



/*============================== SCRIPTS & STYLES ======================================================================================================================*/

function teslawp_scripts() {

    $protocol = is_ssl() ? 'https' : 'http';

    wp_enqueue_style('teslawp-style', get_template_directory_uri() . '/css/style.css',false,null);
    wp_enqueue_style('teslawp-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css',array('teslawp-style'),null);
    wp_enqueue_style('teslawp-style-wp', get_template_directory_uri() . '/style.css',false,null);

    wp_enqueue_script('jquery');

    wp_enqueue_script('teslawp-plugins', get_template_directory_uri() . '/js/plugins.js',array('jquery'),null);
    wp_enqueue_script('teslawp-main-script', get_template_directory_uri() . '/js/script.js',array('jquery','teslawp-plugins'),null);

    wp_enqueue_script('teslawp-gmap', "$protocol://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places",array(),null);

    wp_localize_script( "teslawp-main-script", "teslawp_main", array( "ajaxurl" => admin_url( "admin-ajax.php" ) ) );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( "comment-reply", array('jquery') );

    if(tesla_go('logo_text_font')){
        $font = str_replace(' ', '+', tesla_go('logo_text_font'));
        wp_enqueue_style( 'tesla-custom-font', "$protocol://fonts.googleapis.com/css?family=$font");
    }

}

function teslawp_admin_scripts($hook_suffix) {
    if ('widgets.php' == $hook_suffix) {
        wp_enqueue_media();
        wp_enqueue_script('teslawp-widget-script', get_template_directory_uri() . '/js/teslawp_admin_widgets.js', array('media-upload', 'media-views'),null);
    }
    if ($hook_suffix == 'post-new.php' || $hook_suffix == 'post.php') {
        wp_enqueue_script('teslawp-post-script', get_template_directory_uri() . '/js/teslawp_admin_post.js',array('jquery'),null);
    }
}

if(!is_admin())
    add_action('wp_enqueue_scripts', 'teslawp_scripts');
else
    add_action('admin_enqueue_scripts', 'teslawp_admin_scripts');

function teslawp_header(){
    $background_image = tesla_go('bg_image');
    $background_position = tesla_go('bg_image_position');
    $background_repeat = tesla_go('bg_image_repeat');
    $background_attachment = tesla_go('bg_image_attachment');
    $background_color = tesla_go('bg_color');
    echo '<style type="text/css">';
    $default = tesla_go('site_color');
    if(empty($default))
        $default = '#c0392b';
    ?>
    <style type="text/css">
    .textcolor{
        color: <?php echo $default; ?>;
    }
    .textcolor_hover:hover{
        color: <?php echo $default; ?>;
    }
    .bgcolor{
        background-color: <?php echo $default; ?>;
    }
    .bgcolor_hover:hover{
        background-color: <?php echo $default; ?>;
    }
    .bordercolor{
        border-color: <?php echo $default; ?>;
    }
    .social a:hover img{
        background-color: <?php echo $default; ?>;
    }
    .menuContainer>ul.menu>li.menuactive>a,
    .menuContainer>ul.menu>li>a:hover{
        background-color: <?php echo $default; ?>;
    }
    .menuContainer div.menuLevel>ul.menuDrop>li:hover>a{
        background-color: <?php echo $default; ?>;
    }
    .menuContainer div.menuLevel>ul.menuDrop>li>div.menuDropArrow{
        background-color: <?php echo $default; ?>;
    }
    .titleContainer{
        border-bottom-color: <?php echo $default; ?>;
    }
    .titleContainer .title{
        border-bottom-color: <?php echo $default; ?>;
    }
    .titleContainer .clientsNav .clientsNavPrev{
        background-color: <?php echo $default; ?>;
    }
    .titleContainer .clientsNav .clientsNavNext{
        background-color: <?php echo $default; ?>;
    }
    .widgetFlickr .widgetFlickrImg:hover{
        border-color: <?php echo $default; ?>;
    }
    .contact .contactForm fieldset.contactFormButtons input[type="submit"]:hover,
    .contactForm fieldset.contactFormButtons input[type="submit"]:hover,
    .contact .contactForm fieldset.contactFormButtons input[type="reset"]:hover,
    .contactForm fieldset.contactFormButtons input[type="reset"]:hover{
        background-color: <?php echo $default; ?>;
    }
    .pageSlider ul.pageSliderNav li.active,
    .pageSlider ul.pageSliderNav li:hover{
        background-color: <?php echo $default; ?>;
    }
    .widgetCategories ul li a span{
        background-color: <?php echo $default; ?>;
    }
    .widgetCategories ul li a:hover{
        color: <?php echo $default; ?>;
    }
    .widgetGallery .widgetGalleryImg a:hover img{
        border-color: <?php echo $default; ?>;
    }
    .widgetWorks .widgetWorksEntry .widgetWorksEntryImg a span{
        background-color: <?php echo $default; ?>;
    }
    .widgetWorks .widgetWorksEntry .widgetWorksEntryImg a:hover img{
        border-color: <?php echo $default; ?>;
    }
    .works .worksFilter ul.worksFilterCategories li.worksFilterCategoriesActive div,
    .works .worksFilter ul.worksFilterCategories li:hover div{
        background-color: <?php echo $default; ?>;
    }
    .works .worksViews .worksViewsOption.worksViewsOptionActive,
    .works .worksViews .worksViewsOption:hover{
        border-color: <?php echo $default; ?>;
    }
    .works .worksContainer.worksContainerView1 .worksEntry .worksEntryContainer .worksEntryInfo .worksEntryInfoMore:hover{
        background-color: <?php echo $default; ?>;
    }
    .works .worksContainer.worksContainerView2 .worksEntry .worksEntryContainer .worksEntryInfo .worksEntryInfoTitle a:hover{
        color: <?php echo $default; ?>;
    }
    .blog .blogEntry .blogEntryTitle a:hover{
        color: <?php echo $default; ?>;
    }
    .blog .blogEntry .blogEntryFooter .blogEntryFooterComments a{
        color: <?php echo $default; ?>;
        border-color: <?php echo $default; ?>;
    }
    .blogNav a.blogNavActive,
    .blogNav a:hover{
        color: <?php echo $default; ?>;
    }
    .post .postForm .postFormButtons input:hover{
        background-color: <?php echo $default; ?>;
    }
    .project .projectInfo .projectInfoDetails .projectInfoDetailsEntry .projectInfoDetailsEntryBody a{
        color: <?php echo $default; ?>;
    }
    .footer .footerColumn .widget .widgetBody a:hover{
        color: <?php echo $default; ?>;
    }
    .sidebar .widget_teslawp_categories ul li a span{
        background-color: <?php echo $default; ?>;
    }
    ul.page-numbers a:hover,
    ul.page-numbers span.current{
        color: <?php echo $default; ?>;
    }
    #postForm p.form-submit #submit:hover{
        background-color: <?php echo $default; ?>;
    }
    #reply-title a:hover{
        color: <?php echo $default; ?>;
    }
    .sidebar .widget table tfoot tr td a:hover{
        color: <?php echo $default; ?>;
    }
    .sidebar .widget table tbody tr td a:hover{
        background-color: <?php echo $default; ?>;
    }
    .sidebar .widget .tagcloud a:hover,
    .sidebar .widget .textwidget a:hover{
        color: <?php echo $default; ?>;
    }
    .sidebar .widget .widgetTitle a:hover{
        color: <?php echo $default; ?>;
    }
    .sidebar .widget #searchform #searchsubmit:hover{
        background-color: <?php echo $default; ?>;
    }
    .sidebar .widgetWorks .widgetWorksEntry .widgetWorksEntryImg a:hover{
        border-color: <?php echo $default; ?>;
    }
    .searchNoResults form input#searchsubmit:hover{
        background-color: <?php echo $default; ?>;
    }
    .footerColumn a:hover{
        color: <?php echo $default; ?>;
    }
    .footerColumn .widget_search #searchsubmit:hover{
        background-color: <?php echo $default; ?>;
    }
    .menuContainer > ul.menu > li.current_page_item > a,
    .menuContainer > ul.menu > li.current-menu-item > a{
        background-color: <?php echo $default; ?>;
    }
    .post-numbers{
        color: <?php echo $default; ?>;
    }
    .post-numbers a:hover,
    .postFooter a:hover,
    .pingback a:hover,
    .postCommentsEntryBodyMessage a:hover,
    .post .postBody a:hover,
    .pageContents a:hover,
    .postCommentsEntryBodyUser a:hover,
    .trackback a:hover{
        color: <?php echo $default; ?>;
    }
    .pageContents input[type="submit"]:hover,
    .pageContents input[type="reset"]:hover{
        background-color: <?php echo $default; ?>;
    }
    .sidebar .widget ul li a:hover, .sidebar .widget_teslawp_categories ul li a:hover{
        color: <?php echo $default; ?>;
    }
    .tesla_blog_name,
    .tesla_blog_description{
        color: <?php echo $default; ?>;
    }
    <?php
    echo tesla_go('custom_css');
    echo '</style>';

    echo _gmap('map-canvas');
    $favicon = tesla_go('favicon');
    if(!empty($favicon))
        echo '<link rel="icon" type="image/png" href="'.$favicon.'">';
}
add_action('wp_head','teslawp_header',1000);

function teslawp_footer(){
    echo tesla_go('append_to_footer');
}
add_action('wp_footer','teslawp_footer',1000);



/*============================== WIDGETS ======================================================================================================================*/

require_once get_template_directory() . '/widgets/categories.php';
require_once get_template_directory() . '/widgets/contact.php';
require_once get_template_directory() . '/widgets/flickr.php';
require_once get_template_directory() . '/widgets/gallery.php';
require_once get_template_directory() . '/widgets/latest_posts.php';
require_once get_template_directory() . '/widgets/recent_works.php';

// ========================Notice GoPro=================================
if(!get_transient( 'tt_gopro_notice_dismissed' )){
    add_action( 'admin_notices', 'tt_purchase_notice' );
    add_action( 'admin_footer' , 'tt_purchase_notice_script' );
    add_action( 'wp_ajax_tt_dismiss_notice', 'tt_dismiss_notice_ajax' );
}

function tt_purchase_notice(){
    echo "<div class='notice update-nag is-dismissible tt-purchase-notice'> <p>Are you stuck and feel limited within the Theme ? <a target='_blank' href='http://teslathemes.com/wp-themes/revoke/?utm_source=Framework&utm_medium=FWButton&utm_campaign=GoPro'>Go Pro</a> with <a target='_blank' href='http://teslathemes.com/wp-themes/revoke/?utm_source=Framework&utm_medium=FWButton&utm_campaign=GoPro'>Revoke</a> ( Premium version of Tesla ) or <a target='_blank' href='http://teslathemes.com/wp-themes/revoke/?utm_source=Framework&utm_medium=FWButton&utm_campaign=GoPro'>Revoke2</a> to unlock <b>Premium</b> Features & get <b>Professional Support</b></p></div>"; 
}

function tt_dismiss_notice_ajax(){
    set_transient( 'tt_gopro_notice_dismissed' , true , 5 * DAY_IN_SECONDS );
}

function tt_purchase_notice_script(){ ?>    
    <script type="text/javascript">jQuery('body').on('click','.tt-purchase-notice .notice-dismiss',function(){
      jQuery.post(ajaxurl, {action:'tt_dismiss_notice'});
    })</script>
    <?php
}
//==========================GoPro End=======================

function teslawp_register_widgets() {
    register_widget('Tesla_categories_widget');
    register_widget('Tesla_latest_posts_widget');
    register_widget('Tesla_sidebar_gallery_widget');
    register_widget('Tesla_recent_works_widget');
    register_widget('Tesla_flickr_widget');
    register_widget('Tesla_contact_widget');
}

add_action('widgets_init', 'teslawp_register_widgets');

class Walker_Category_teslawp extends Walker_Category {

    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        extract($args);

        $cat_name = esc_attr($category->name);
        $cat_name = apply_filters('list_cats', $cat_name, $category);
        $link = '<a href="' . esc_url(get_term_link($category)) . '" ';
        if ($use_desc_for_title == 0 || empty($category->description))
            $link .= 'title="' . esc_attr(sprintf(__('View all posts filed under %s','teslawp'), $cat_name)) . '"';
        else
            $link .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
        $link .= '><span></span>';
        $link .= $cat_name . '</a>';

        if (!empty($feed_image) || !empty($feed)) {
            $link .= ' ';

            if (empty($feed_image))
                $link .= '(';

            $link .= '<a href="' . esc_url(get_term_feed_link($category->term_id, $category->taxonomy, $feed_type)) . '"';

            if (empty($feed)) {
                $alt = ' alt="' . sprintf(__('Feed for all posts filed under %s','teslawp'), $cat_name) . '"';
            } else {
                $title = ' title="' . $feed . '"';
                $alt = ' alt="' . $feed . '"';
                $name = $feed;
                $link .= $title;
            }

            $link .= '>';

            if (empty($feed_image))
                $link .= $name;
            else
                $link .= "<img src='$feed_image'$alt$title" . ' />';

            $link .= '</a>';

            if (empty($feed_image))
                $link .= ')';
        }

        if (!empty($show_count))
            $link .= ' (' . intval($category->count) . ')';

        if ('list' == $args['style']) {
            $output .= "\t<li";
            $class = 'cat-item cat-item-' . $category->term_id;
            if (!empty($current_category)) {
                $_current_category = get_term($current_category, $category->taxonomy);
                if ($category->term_id == $current_category)
                    $class .= ' current-cat';
                elseif ($category->term_id == $_current_category->parent)
                    $class .= ' current-cat-parent';
            }
            $output .= ' class="' . $class . '"';
            $output .= ">$link\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }

}



/*============================== FILTERS ======================================================================================================================*/

function widget_teslawp_categories_args_filter() {
    $args = func_get_args();
    $args[0]['walker'] = new Walker_Category_teslawp;
    return $args[0];
}

function teslawp_read_more_filter() {
    return '';
}

add_filter('widget_teslawp_categories_args', 'widget_teslawp_categories_args_filter');
add_filter('excerpt_more', 'teslawp_read_more_filter');

function teslawp_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    $title .= get_bloginfo( 'name' );
    
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'teslawp' ), max( $paged, $page ) );

    return $title;
}

add_filter( 'wp_title', 'teslawp_wp_title', 10, 2 );

function teslawp_video_wrapper($html) {

    return '<div class="tesla_video_wrapper">'.$html.'</div>';
    
}

add_filter( 'embed_oembed_html', 'teslawp_video_wrapper');

function teslawp_the_title($title) {

    if(''===$title)
        $title = 'Untitled';

    return $title;
    
}

add_filter( 'the_title', 'teslawp_the_title');



/*============================== COMMENTS ======================================================================================================================*/

function teslawp_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type) :
        case 'pingback' :
        case 'trackback' :
            ?>
            <div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <p><?php _e('Pingback:', 'teslawp'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('(Edit)', 'teslawp'), '<span class="edit-link">', '</span>'); ?></p>
                <?php
                break;
            default :
                global $post;
                ?>

                <div <?php comment_class(array('postCommentsEntry')); ?>>

                <div class="postCommentsEntryAvatar">
                    <?php echo get_avatar($comment, 50); ?>
                </div>

                <div class="postCommentsEntryBody">

                <div class="postCommentsEntryBodyUser">
                    <?php echo get_comment_author_link(); ?>
                </div>
                <div class="postCommentsEntryBodyDate">
                    <?php comment_date('F jS, Y'); ?> at <?php comment_time('g:i a'); ?>
                </div>
                <div class="postCommentsEntryBodyMessage">
                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'teslawp'); ?></p>
                    <?php endif; ?>
                    <?php comment_text(); ?>
                </div>
                <div class="postCommentsEntryBodyButton" id="comment-<?php comment_ID(); ?>">
                    <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'teslawp'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                    <?php edit_comment_link(__('Edit', 'teslawp')); ?>
                </div>
                <div class="postCommentsEntryBodyReplies">

            <?php
            break;
    endswitch;
}

function teslawp_comment_end($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type) :
        case 'pingback' :
        case 'trackback' :
            ?>
                </div>
            <?php
            break;
        default :
            ?>
                </div></div></div>
            <?php
            break;
    endswitch;
}



/*============================== META BOXES ======================================================================================================================*/

function teslawp_featured_video($post) {
    wp_nonce_field(-1, 'teslawp_featured_video_nonce');
    $value = get_post_meta($post->ID, 'teslawp_featured_video_id', true);
    $enabled = get_post_meta($post->ID, 'teslawp_featured_video_enabled', true);
    ?>
    <label><input <?php if ($enabled === '1') echo 'checked="checked" '; ?>value="" type="checkbox" name="teslawp_featured_video_input_check_name" id="teslawp_featured_video_input_check_id"> <?php _e('Enable featured video', 'teslawp'); ?></label>
    <br/>
    <?php
    echo '<input ' . ($enabled === '0' || $enabled === '' ? 'style="display:none;" ' : '') . 'type="text" id="teslawp_featured_video_input_id" name="teslawp_featured_video_input_name" value="' . esc_attr($value) . '" size="25" />';
}

function teslawp_featured_video_save($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['teslawp_featured_video_nonce']) || !wp_verify_nonce($_POST['teslawp_featured_video_nonce']))
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (wp_is_post_revision($post_id) === false) {

        $video = $_POST['teslawp_featured_video_input_name'];
        $enabled = $_POST['teslawp_featured_video_input_check_name'] === NULL ? '0' : '1';

        add_post_meta($post_id, 'teslawp_featured_video_id', $video, true) or
                update_post_meta($post_id, 'teslawp_featured_video_id', $video);
        add_post_meta($post_id, 'teslawp_featured_video_enabled', $enabled, true) or
                update_post_meta($post_id, 'teslawp_featured_video_enabled', $enabled);
    }
}

function teslawp_disable_title($post) {
    wp_nonce_field(-1, 'teslawp_disable_title_nonce');
    $enabled = get_post_meta($post->ID, 'teslawp_disable_title_check', true);
    ?>
    <label>
        <input <?php checked($enabled); ?> type="checkbox" name="teslawp_disable_title_input_check">
        <?php _e('Disable Page Title', 'teslawp'); ?>
    </label>
    <?php
}

function teslawp_disable_sidebar($post) {
    wp_nonce_field(-1, 'teslawp_disable_sidebar_nonce');
    $enabled = get_post_meta($post->ID, 'teslawp_disable_sidebar_check', true);
    ?>
    <label>
        <input <?php checked($enabled); ?> type="checkbox" name="teslawp_disable_sidebar_input_check">
        <?php _e('Disable Page Sidebar', 'teslawp'); ?>
    </label>
    <?php
}

function teslawp_alternative_sidebar($post) {

    global $wp_registered_sidebars;  
      
    $custom = get_post_custom($post->ID);
      
    if(isset($custom['custom_sidebar']))  
        $val = $custom['custom_sidebar'][0];  
    else  
        $val = "default";  
  
    wp_nonce_field(-1,'custom_sidebar_nonce' );  
  
    $output = '<p>'.__("Choose a sidebar to be displayed", 'teslawp' ).'</p>';  
    $output .= "<select name='custom_sidebar'>";  
  
    $output .= "<option";  
    if($val == "default")  
        $output .= " selected='selected'";  
    $output .= " value='default'>".__('default', 'teslawp')."</option>";  
      
    foreach($wp_registered_sidebars as $sidebar_id => $sidebar)  
    {  
        $output .= "<option";  
        if($sidebar_id == $val)  
            $output .= " selected='selected'";  
        $output .= " value='".$sidebar_id."'>".$sidebar['name']."</option>";  
    }  
    
    $output .= "</select>";  
      
    echo $output;
}

function teslawp_disable_padding($post) {
    wp_nonce_field(-1, 'teslawp_disable_padding_nonce');
    $enabled = get_post_meta($post->ID, 'teslawp_disable_padding_check', true);
    ?>
    <label>
        <input <?php checked($enabled); ?> type="checkbox" name="teslawp_disable_padding_input_check">
        <?php _e('Remove the spacing at the bottom of the page', 'teslawp'); ?>
    </label>
    <?php
}

function teslawp_disable_title_save($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['teslawp_disable_title_nonce']) || !wp_verify_nonce($_POST['teslawp_disable_title_nonce']))
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (wp_is_post_revision($post_id) === false) {

        $enabled = $_POST['teslawp_disable_title_input_check'] === NULL ? false : true;

        add_post_meta($post_id, 'teslawp_disable_title_check', $enabled, true) or
                update_post_meta($post_id, 'teslawp_disable_title_check', $enabled);
    }
}

function teslawp_disable_sidebar_save($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['teslawp_disable_sidebar_nonce']) || !wp_verify_nonce($_POST['teslawp_disable_sidebar_nonce']))
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (wp_is_post_revision($post_id) === false) {

        $enabled = $_POST['teslawp_disable_sidebar_input_check'] === NULL ? false : true;

        add_post_meta($post_id, 'teslawp_disable_sidebar_check', $enabled, true) or
                update_post_meta($post_id, 'teslawp_disable_sidebar_check', $enabled);
    }
}

function teslawp_alternative_sidebar_save($post_id) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )   
      return;  

    if (!isset($_POST['custom_sidebar_nonce']) || !wp_verify_nonce($_POST['custom_sidebar_nonce']))
        return;
  
    if ( !current_user_can( 'edit_page', $post_id ) )  
        return;  
  
    if (wp_is_post_revision($post_id) === false) {
        $data = $_POST['custom_sidebar'];

        add_post_meta($post_id, "custom_sidebar", $data,true) or
            update_post_meta($post_id, "custom_sidebar", $data); 
    }
}

function teslawp_disable_padding_save($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['teslawp_disable_padding_nonce']) || !wp_verify_nonce($_POST['teslawp_disable_padding_nonce']))
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (wp_is_post_revision($post_id) === false) {

        $enabled = $_POST['teslawp_disable_padding_input_check'] === NULL ? false : true;

        add_post_meta($post_id, 'teslawp_disable_padding_check', $enabled, true) or
                update_post_meta($post_id, 'teslawp_disable_padding_check', $enabled);
    }
}

function teslawp_meta_boxes() {
    add_meta_box('teslawp_featured_video_id', 'Featured Video', 'teslawp_featured_video', 'post', 'side', 'low');
    add_meta_box('teslawp_featured_video_id', 'Featured Video', 'teslawp_featured_video', 'page', 'side', 'low');
    add_meta_box('teslawp_disable_title_id', 'Disable Title', 'teslawp_disable_title', 'page', 'side', 'low');
    add_meta_box('teslawp_disable_sidebar', 'Disable Sidebar', 'teslawp_disable_sidebar', 'page', 'side', 'low');
    add_meta_box('teslawp_alternative_sidebar', 'Alternative Sidebar', 'teslawp_alternative_sidebar', 'page', 'side', 'low');
    add_meta_box('teslawp_disable_padding', 'Disable Page Bottom Padding', 'teslawp_disable_padding', 'page', 'side', 'low');
}

add_action('add_meta_boxes', 'teslawp_meta_boxes');
add_action('save_post', 'teslawp_featured_video_save');
add_action('save_post', 'teslawp_disable_title_save');
add_action('save_post', 'teslawp_disable_sidebar_save');
add_action('save_post', 'teslawp_alternative_sidebar_save');
add_action('save_post', 'teslawp_disable_padding_save');



/*============================== MENU ======================================================================================================================*/

class Tesla_Nav_Menu_Walker extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"menuLevel\"><ul class=\"sub-menu menuDrop font3\">\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>'.($depth?'<div class="menuDropArrow"></div>':'');

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

class Tesla_List_Pages_Walker extends Walker_Page {

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"menuLevel\"><ul class='children menuDrop font3'>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }

    function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
        if ( $depth )
            $indent = str_repeat("\t", $depth);
        else
            $indent = '';

        extract($args, EXTR_SKIP);
        $css_class = array('page_item', 'page-item-'.$page->ID);
        if ( !empty($current_page) ) {
            $_current_page = get_post( $current_page );
            if ( in_array( $page->ID, $_current_page->ancestors ) )
                $css_class[] = 'current_page_ancestor';
            if ( $page->ID == $current_page )
                $css_class[] = 'current_page_item';
            elseif ( $_current_page && $page->ID == $_current_page->post_parent )
                $css_class[] = 'current_page_parent';
        } elseif ( $page->ID == get_option('page_for_posts') ) {
            $css_class[] = 'current_page_parent';
        }

        $css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

        $output .= $indent . '<li class="' . $css_class . '">'.($depth?'<div class="menuDropArrow"></div>':'').'<a href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';

        if ( !empty($show_date) ) {
            if ( 'modified' == $show_date )
                $time = $page->post_modified;
            else
                $time = $page->post_date;

            $output .= " " . mysql2date($date_format, $time);
        }
    }
}

class Tesla_Nav_Menu_Select_Walker extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth = 0, $args = array() ) {

    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {

    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $pad = str_repeat('&nbsp;', $depth * 3);

        $output .= "\t<option class=\"level-$depth\" value=\"".$item->url."\"";
        if ( isset($args->selected) && $item->url == $args->selected )
            $output .= ' selected="selected"';
        $output .= '>';
        $title = $item->title;
        $output .= $pad . esc_html( $title );
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</option>\n";
    }
}

class Tesla_List_Pages_Select_Walker extends Walker_Page {

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        
    }

    function start_el(&$output, $page, $depth = 0, $args = array(), $id = 0 ) {
        $pad = str_repeat('&nbsp;', $depth * 3);

        $url = get_permalink($page->ID);

        $output .= "\t<option class=\"level-$depth\" value=\"".$url."\"";
        if ( isset($args->selected) && $url == $args->selected )
            $output .= ' selected="selected"';
        $output .= '>';
        $title = $page->post_title;
        $output .= $pad . esc_html( $title );
    }

    function end_el( &$output, $page, $depth = 0, $args = array() ) {
        $output .= "</option>\n";
    }
}

add_theme_support( "title-tag" );