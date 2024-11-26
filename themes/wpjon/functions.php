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
    // Enqueue main stylesheet
    wp_enqueue_style('wpjon-style', get_stylesheet_uri());
    
    // Enqueue hero styles
    wp_enqueue_style(
        'wpjon-hero', 
        get_template_directory_uri() . '/css/hero.css',
        array('wpjon-style'), // Make it dependent on main stylesheet
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'wpjon_enqueue_styles');

function enqueue_homepage_content() {
    wp_enqueue_style('homepage-content', get_template_directory_uri() . '/css/homepageContent.css');
    wp_enqueue_script('homepage-content', get_template_directory_uri() . '/js/homepageContent.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_homepage_content');