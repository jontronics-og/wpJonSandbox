<?php 
require get_template_directory() . '/inc/customizer.php';

// Preconnect to Google Fonts
function wpjon_preconnect_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'wpjon_preconnect_google_fonts', 1);

// Debug paths - temporarily add this to verify paths
function debug_paths() {
    error_log('Template Directory: ' . get_template_directory());
    error_log('Template URI: ' . get_template_directory_uri());
}
add_action('init', 'debug_paths');

// Inline critical CSS
function wpjon_inline_critical_css() {
    $critical_css_path = get_template_directory() . '/css/min/critical.min.css';
    if (file_exists($critical_css_path)) {
        $critical_css = file_get_contents($critical_css_path);
        if ($critical_css) {
            echo '<style id="critical-css">' . $critical_css . '</style>';
        }
    }
}
add_action('wp_head', 'wpjon_inline_critical_css', 1);

// Base styles and scripts
function wpjon_load_scripts(){
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    wp_enqueue_style(
        'wpjon-style', 
        get_stylesheet_uri(), 
        array(), 
        filemtime($theme_dir . '/style.css'), 
        'all'
    );
   
    wp_enqueue_style(
        'google-fonts', 
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap&display=swap', 
        array(), 
        null
    );

    wp_enqueue_script(
        'dropdown', 
        $theme_uri . '/js/min/dropdown.min.js', 
        array(), 
        filemtime($theme_dir . '/js/min/dropdown.min.js'), 
        true
    );
}
add_action('wp_enqueue_scripts', 'wpjon_load_scripts');

// Theme configuration
function wpjon_config() {
    $textdomain = 'wpjon';
    load_theme_textdomain($textdomain, get_template_directory() . '/languages/');

    register_nav_menus(array(
        'wp_devs_main_menu' => __('Main Menu', 'wpjon'),
        'wp_devs_footer_menu' => __('Footer Menu', 'wpjon')
    ));

    add_theme_support('custom-header', array(
        'height' => 225,
        'width' => 1920
    ));
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'width' => 200,
        'height' => 110,
        'flex-height' => true,
        'flex-width' => true
    ));
}
add_action('after_setup_theme', 'wpjon_config', 0);

// Sidebars registration
function wpjon_sidebars(){
    register_sidebar(array(
        'name' => 'Blog Sidebar',
        'id' => 'sidebar-blog',
        'description' => 'This is the Blog Sidebar. You can add your widgets here.',
        'before_widget' => '<div class="widget-wrapper">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
    ));

    register_sidebar(array(
        'name' => 'Service 1',
        'id' => 'services-1',
        'description' => 'First Service Area',
        'before_widget' => '<div class="widget-wrapper">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
    ));

    register_sidebar(array(
        'name' => 'Service 2',
        'id' => 'services-2',
        'description' => 'Second Service Area',
        'before_widget' => '<div class="widget-wrapper">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
    ));

    register_sidebar(array(
        'name' => 'Service 3',
        'id' => 'services-3',
        'description' => 'Third Service Area',
        'before_widget' => '<div class="widget-wrapper">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
    ));
}
add_action('widgets_init', 'wpjon_sidebars');

// Homepage specific scripts and styles
function wpjon_enqueue_homepage_assets() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    if (is_front_page() || is_page_template('page-home.php')) {
        // GSAP
        wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', true);
        wp_enqueue_script('gsap-motionpath', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MotionPathPlugin.min.js', array('gsap'), '3.12.2', true);
        
        // Hero section
        wp_enqueue_script(
            'hero-animations', 
            $theme_uri . '/js/min/heroAnimations.min.js', 
            array('gsap', 'gsap-motionpath'), 
            filemtime($theme_dir . '/js/min/heroAnimations.min.js'), 
            true
        );
        wp_enqueue_style(
            'wpjon-hero', 
            $theme_uri . '/css/min/hero.min.css', 
            array('wpjon-style'), 
            filemtime($theme_dir . '/css/min/hero.min.css')
        );
        
        // Homepage content
        wp_enqueue_style(
            'homepage-content', 
            $theme_uri . '/css/min/homepagecontent.min.css', 
            array(), 
            filemtime($theme_dir . '/css/min/homepagecontent.min.css')
        );
        wp_enqueue_script(
            'homepage-content', 
            $theme_uri . '/js/min/homePageContent.min.js', 
            array('gsap'), 
            filemtime($theme_dir . '/js/min/homePageContent.min.js'), 
            true
        );
        
        // Work section
        wp_enqueue_style(
            'homepage-work', 
            $theme_uri . '/css/min/homepageworkcontent.min.css', 
            array(), 
            filemtime($theme_dir . '/css/min/homepageworkcontent.min.css')
        );
        
        // Testimonials
        wp_enqueue_style(
            'homepage-testimonials', 
            $theme_uri . '/css/min/homepagetestimonials.min.css', 
            array(), 
            filemtime($theme_dir . '/css/min/homepagetestimonials.min.css')
        );
        wp_enqueue_script(
            'testimonials-background', 
            $theme_uri . '/js/min/testimonialsBackGround.min.js', 
            array('gsap'), 
            filemtime($theme_dir . '/js/min/testimonialsBackGround.min.js'), 
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'wpjon_enqueue_homepage_assets');

// Header navigation
function wpjon_enqueue_header_nav() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();
    
    wp_enqueue_script(
        'wpjon-header-nav', 
        $theme_uri . '/js/min/headernav.min.js', 
        array('gsap'), 
        filemtime($theme_dir . '/js/min/headernav.min.js'), 
        true
    );
    wp_enqueue_style(
        'wpjon-header-nav', 
        $theme_uri . '/css/min/headernav.min.css', 
        array(), 
        filemtime($theme_dir . '/css/min/headernav.min.css')
    );
}
add_action('wp_enqueue_scripts', 'wpjon_enqueue_header_nav');

// Single post specific assets
function wpjon_enqueue_single_post_assets() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    if (is_single()) {
        wp_enqueue_style(
            'single-blog-styles', 
            $theme_uri . '/css/min/single-blog.min.css',
            array(),
            filemtime($theme_dir . '/css/min/single-blog.min.css')
        );
        wp_enqueue_script(
            'smooth-scroll', 
            $theme_uri . '/js/min/singleBlog.min.js', 
            array(), 
            filemtime($theme_dir . '/js/min/singleBlog.min.js'), 
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'wpjon_enqueue_single_post_assets');

// Reading time calculator
function get_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    return $reading_time . ' min read';
}

// Table of contents functions
function generate_table_of_contents() {
    global $post;
    $content = $post->post_content;
    $matches = array();
    
    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/', $content, $matches);

    if (!empty($matches[1])) {
        echo '<ul>';
        foreach ($matches[1] as $heading) {
            $clean_heading = strip_tags($heading);
            $anchor = sanitize_title($clean_heading);
            echo '<li><a href="#' . esc_attr($anchor) . '">' . esc_html($clean_heading) . '</a></li>';
        }
        echo '</ul>';
    }
}

function add_ids_to_headings($content) {
    $pattern = '/<h2([^>]*)>(.*?)<\/h2>/i';
    
    $content = preg_replace_callback($pattern, function($matches) {
        $attributes = $matches[1];
        $heading_text = $matches[2];
        $clean_heading = strip_tags($heading_text);
        $anchor = sanitize_title($clean_heading);
        
        if (!empty($attributes)) {
            if (strpos($attributes, 'id=') === false) {
                $attributes .= ' id="' . esc_attr($anchor) . '"';
            }
        } else {
            $attributes = ' id="' . esc_attr($anchor) . '"';
        }
        
        return "<h2{$attributes}>{$heading_text}</h2>";
    }, $content);
    
    return $content;
}
add_filter('the_content', 'add_ids_to_headings', 99);

// REST API format
add_filter('acf/settings/rest_api_format', function () {
    return 'standard';
});