<?php

/**
 * WpMart Portfolio Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WpMart_Portfolio_Theme
 */

// Theme Setup
if (!function_exists('wpmart_portfolio_setup')) {
    function wpmart_portfolio_setup()
    {
        load_theme_textdomain('wpmart-portfolio', get_template_directory() . '/languages');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        register_nav_menus(array('menu-1' => esc_html__('Primary', 'wpmart-portfolio')));
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        add_theme_support('custom-logo', array(
            'height'      => 100,
            'width'       => 250,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array('site-title', 'site-description'),
        ));
    }
}
add_action('after_setup_theme', 'wpmart_portfolio_setup');

function theme_customizer_css() {
    ?>
    <style type="text/css">
        :root {
            --wp--preset--color--primary: <?php echo get_theme_mod('primary_color', '#0A2647'); ?>;
            --wp--preset--color--secondary: <?php echo get_theme_mod('secondary_color', '#144272'); ?>;
            --wp--preset--color--button: <?php echo get_theme_mod('button_color', '#205295'); ?>;
            --wp--preset--color--button--hover: <?php echo get_theme_mod('button_hover_color', '#1e5daf'); ?>;
            --wp--preset--color--text: <?php echo get_theme_mod('text_color', '#0F2C59'); ?>;
            --wp--preset--color--link: <?php echo get_theme_mod('link_color', '#2C74B3'); ?>;
            --wp--preset--color--white: <?php echo get_theme_mod('white_color', '#ffffff'); ?>;
            --wp--preset--color--section--background: <?php echo get_theme_mod('section_background_color', '#EFEFEF'); ?>;
            --wp--preset--color--box--shadow: <?php echo get_theme_mod('box_shadow_color', '#efefef'); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'theme_customizer_css', 100);

// Register Sidebar
function wpmart_portfolio_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'wpmart-portfolio'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'wpmart-portfolio'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'wpmart_portfolio_widgets_init');

function wpmart_sanitize_checkbox($checked)
{
    return (isset($checked) && true === $checked) ? true : false;
}

// Meta info for website URL
function wpmart_register_meta() {
    register_post_meta('post', '_website_url_meta_key', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
}
add_action('init', 'wpmart_register_meta');

function wpmart_add_website_url_metabox() {
    add_meta_box('wpmart_website_url', 'Website URL', 'wpmart_website_url_callback', 'post');
}
add_action('add_meta_boxes', 'wpmart_add_website_url_metabox');

function wpmart_website_url_callback($post) {
    $website_url = get_post_meta($post->ID, '_website_url_meta_key', true);
    echo '<label for="wpmart_website_url_field">Website URL: </label>';
    echo '<input type="text" id="wpmart_website_url_field" name="_website_url_meta_key" value="' . esc_attr($website_url) . '" style="width:50%;"/>';
}

function wpmart_save_website_url_meta_box_data($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['_website_url_meta_key'])) {
        update_post_meta(
            $post_id,
            '_website_url_meta_key',
            sanitize_text_field($_POST['_website_url_meta_key'])
        );
    }
}
add_action('save_post', 'wpmart_save_website_url_meta_box_data');

// Lazy load Images
function my_lazy_load_filter( $content ) {
	$content = preg_replace( '/(<img[^>]+src="[^"]*")/', '$1 data-src="$1" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="', $content );
  return $content;
	
}
add_filter( 'the_content', 'my_lazy_load_filter' );


// Include theme files
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';


// Register Scripts & Styles
function wpmart_portfolio_enqueue_scripts()
{
    wp_enqueue_style('wpmart-portfolio-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_style_add_data('wpmart-portfolio-style', 'rtl', 'replace');

    // Enqueue Slick slider scripts and styles
    wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/assets/css/slick.css' );
    wp_enqueue_style( 'slick-theme-css', get_template_directory_uri() . '/assets/css/slick-theme.css' );
    wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '1.8.1', true );
	wp_enqueue_script( 'lazyload-script', get_template_directory_uri() . '/assets/js/lazyload.min.js', array('jquery'), '1.0.0', true );
    
    // isotope Script
    wp_enqueue_script('isotope', get_template_directory_uri() . '/assets/js/isotope.js', array('jquery'), '', true);
    
    // Custom JS
    wp_enqueue_script('wpmart-portfolio-custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery', 'isotope'), '', true);
    
    wp_enqueue_script('wpmart-portfolio-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '1.0.0', true);
    // wp_enqueue_script('wpmart-portfolio-custom-block', get_template_directory_uri() . '/blocks/custom-block/index.js', array(), '1.0.0', true);
    wp_enqueue_script('wpmart-portfolio-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '1.0.0', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'wpmart_portfolio_enqueue_scripts', 100);