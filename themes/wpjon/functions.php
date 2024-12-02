<?php 






require get_template_directory() . '/inc/customizer.php';

function wpjon_load_scripts(){
    wp_enqueue_style( 'wpjon-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ), 'all' );
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap', array(), null );
    wp_enqueue_script( 'dropdown', get_template_directory_uri() . '/js/dropdown.js', array(), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'wpjon_load_scripts' );

function wpjon_config() {
    $textdomain = 'wpjon';
    load_theme_textdomain( $textdomain, get_template_directory() . '/languages/' );

    register_nav_menus(
        array(
            'wp_devs_main_menu' => __( 'Main Menu', 'wpjon' ),
            'wp_devs_footer_menu' => __( 'Footer Menu', 'wpjon' )
        )
    );

    $args = array(
        'height' => 225,
        'width' => 1920
    );
    add_theme_support('custom-header', $args);
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array (
        'width' => 200,
        'height' => 110,
        'flex-height' => true,
        'flex-width' => true
    ));
}
add_action('after_setup_theme', 'wpjon_config', 0);

function wpjon_sidebars(){
    register_sidebar(
        array(
            'name'  => 'Blog Sidebar',
            'id'    => 'sidebar-blog',
            'description'   => 'This is the Blog Sidebar. You can add your widgets here.',
            'before_widget' => '<div class="widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );
    register_sidebar(
        array(
            'name'  => 'Service 1',
            'id'    => 'services-1',
            'description'   => 'First Service Area',
            'before_widget' => '<div class="widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );
    register_sidebar(
        array(
            'name'  => 'Service 2',
            'id'    => 'services-2',
            'description'   => 'Second Service Area',
            'before_widget' => '<div class="widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );
    register_sidebar(
        array(
            'name'  => 'Service 3',
            'id'    => 'services-3',
            'description'   => 'Third Service Area',
            'before_widget' => '<div class="widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );
}
add_action( 'widgets_init', 'wpjon_sidebars' );

function wpjon_enqueue_scripts() {
    // Only load these scripts on the home page
    if (is_front_page() || is_page_template('page-home.php')) {
        wp_enqueue_script(
            'gsap', 
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', 
            array(), 
            '3.12.2', 
            true
        );
        
        wp_enqueue_script(
            'gsap-motionpath', 
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MotionPathPlugin.min.js', 
            array('gsap'), 
            '3.12.2', 
            true
        );
        
        wp_enqueue_script(
            'hero-animations', 
            get_template_directory_uri() . '/js/heroAnimations.js', 
            array('gsap', 'gsap-motionpath'), 
            '1.0.0', 
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'wpjon_enqueue_scripts');

function wpjon_enqueue_styles() {
    // Enqueue hero styles
    wp_enqueue_style(
        'wpjon-hero', 
        get_template_directory_uri() . '/css/hero.css',
        array('wpjon-style'), 
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'wpjon_enqueue_styles');

function enqueue_homepage_content() {
    wp_enqueue_style('homepage-content', get_template_directory_uri() . '/css/homepageContent.css');
    wp_enqueue_script('homepage-content', get_template_directory_uri() . '/js/homepageContent.js', array(), '1.0', true);
    wp_enqueue_style('homepage-testimonials', get_template_directory_uri() . '/css/homepageTestimonials.css');
    wp_enqueue_script('testimonials-background', get_template_directory_uri() . '/js/testimonialsBackground.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_homepage_content');

function wpjon_enqueue_header_nav() {
    // Only enqueue GSAP if it's not already enqueued
    if (!wp_script_is('gsap', 'enqueued')) {
        wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', true);
    }
    
    wp_enqueue_script(
        'wpjon-header-nav', 
        get_template_directory_uri() . '/js/headernav.js', 
        array('gsap'), 
        '1.0.0', 
        true
    );
    
    wp_enqueue_style(
        'wpjon-header-nav', 
        get_template_directory_uri() . '/css/headernav.css', 
        array(), 
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'wpjon_enqueue_header_nav');


// Generate table of contents from h2 headings
function generate_table_of_contents() {
    global $post;
    $content = $post->post_content;
    $matches = array();
    
    // This pattern will match both plain h2 tags and h2 tags with classes
    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/', $content, $matches);

    if (!empty($matches[1])) {
        echo '<ul>';
        foreach ($matches[1] as $heading) {
            // Clean the heading text by removing any HTML tags
            $clean_heading = strip_tags($heading);
            // Create an anchor ID from the cleaned heading
            $anchor = sanitize_title($clean_heading);
            echo '<li><a href="#' . esc_attr($anchor) . '">' . esc_html($clean_heading) . '</a></li>';
        }
        echo '</ul>';
    }
}

// Add IDs to h2 tags in content
function add_ids_to_headings($content) {
    // This will handle both plain h2 tags and h2 tags with existing attributes
    $pattern = '/<h2([^>]*)>(.*?)<\/h2>/i';
    
    $content = preg_replace_callback($pattern, function($matches) {
        $attributes = $matches[1];
        $heading_text = $matches[2];
        
        // Clean the heading text and create the ID
        $clean_heading = strip_tags($heading_text);
        $anchor = sanitize_title($clean_heading);
        
        // If there are existing attributes, we'll append the id
        if (!empty($attributes)) {
            // Check if there's already an ID
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
add_filter('the_content', 'add_ids_to_headings', 99); // Higher priority to run after other content filters

// Enqueue the single blog styles
function enqueue_single_blog_styles() {
    if (is_single()) {
        wp_enqueue_style('single-blog-styles', get_template_directory_uri() . '/css/single-blog.css');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_single_blog_styles');


function get_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Assuming 200 words per minute reading speed

    return $reading_time . ' min read';
}


// Enqueue smooth scroll script
function enqueue_smooth_scroll() {
    if (is_single()) {
        wp_enqueue_script(
            'smooth-scroll',
            get_template_directory_uri() . '/js/singleBlog.js',
            array(),
            '1.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_smooth_scroll');
