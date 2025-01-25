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

// // Custom REST API endpoint for filtered posts
// add_action('rest_api_init', function () {
//     register_rest_route('wpjon/v1', '/filtered-posts', [
//         'methods' => 'GET',
//         'callback' => 'get_filtered_posts',
//         'permission_callback' => '__return_true',
//         'args' => [
//             'categories' => [
//                 'required' => false,
//                 'sanitize_callback' => function($param) {
//                     return array_map('absint', explode(',', $param));
//                 }
//             ],
//             'page' => [
//                 'default' => 1,
//                 'sanitize_callback' => 'absint'
//             ],
//             'per_page' => [
//                 'default' => 8,
//                 'sanitize_callback' => 'absint'
//             ]
//         ]
//     ]);
// });

// function format_post($post_id) {
//     $post = get_post($post_id);
//     $categories = get_the_category($post_id);
    
//     return [
//         'id' => $post_id,
//         'title' => get_the_title($post_id),
//         'link' => get_permalink($post_id),
//         'categories' => array_map(function($cat) {
//             return [
//                 'id' => $cat->term_id,
//                 'name' => $cat->name,
//                 'slug' => $cat->slug
//             ];
//         }, $categories)
//     ];
// }

// function get_filtered_posts($request) {
//     $categories = $request->get_param('categories');
//     $page = $request->get_param('page');
//     $per_page = $request->get_param('per_page');
    
//     $args = [
//         'post_type' => 'post',
//         'posts_per_page' => $per_page,
//         'paged' => $page,
//         'fields' => 'ids'
//     ];
    
//     if ($categories && !empty($categories)) {
//         $args['tax_query'] = array(
//             'relation' => 'OR',  // Shows posts from ANY selected category
//             array(
//                 'taxonomy' => 'category',
//                 'field'    => 'term_id',
//                 'terms'    => $categories
//             )
//         );
//     }
    
//     $query = new WP_Query($args);
    
//     return rest_ensure_response([
//         'posts' => array_map('format_post', $query->posts),
//         'total' => $query->found_posts,
//         'total_pages' => ceil($query->found_posts / $per_page)
//     ]);
// }





//** Surfer APP */



// Load the REST API controller
require_once get_template_directory() . '/inc/class-ny-surf-conditions-api.php';

// Register shortcode
function surf_conditions_shortcode() {
    ob_start(); ?>
        <div class="page-wrapper">
            <div class="content-container">
                <h1 class="page-title">NY SURF CONDITIONS</h1>
                <p class="page-description">Only Ten API calls a day - Check Early Morning</p>
                <div class="button-timer-container">
                    <div class="button-group">
                        <button id="checkSurfBtn" class="check-surf-btn">
                            Check Surf Conditions
                        </button>
                        <button id="lastCheckedBtn" class="last-checked-btn" disabled>
                            Not checked yet
                        </button>
                    </div>
                </div>
                <div id="surfResults" class="surf-results"></div>
            </div>
        </div>
    <?php
    return ob_get_clean();
}
add_shortcode('surf_conditions', 'surf_conditions_shortcode');




function wpjon_enqueue_surf_app_assets() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // CSS
    wp_enqueue_style(
        'surf-test', 
        $theme_uri . '/css/surf-app.css'
    );

    // JavaScript
    wp_enqueue_script(
        'surf-conditions-app',
        $theme_uri . '/js/min/surf-app.min.js',  // Use minified version
        array(), 
        filemtime($theme_dir . '/js/min/surf-app.min.js'),
        true
    );

    // Localize script
    wp_localize_script(
        'surf-conditions-app',
        'surfAppData',
        array(
            'root_url' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        )
    );
}
add_action('wp_enqueue_scripts', 'wpjon_enqueue_surf_app_assets');


// Load the REST API controller
require_once get_template_directory() . '/inc/class-ny-surf-conditions-api.php';

// Initialize the REST API
add_action('rest_api_init', function() {
    $controller = new NY_Surf_Conditions_API();
    $controller->register_routes();
});


function enqueue_surf_template_styles() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    if (is_single() && is_page_template('templates/template-surf.php')) {
        wp_enqueue_style(
            'surf-blog-post-styles',
            $theme_uri . '/css/min/surf-blog-post.min.css',
            array(),
            filemtime($theme_dir . '/css/min/surf-blog-post.min.css')
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_surf_template_styles');




// Drum Machine App 

wp_enqueue_style('drum-machine-styles', get_template_directory_uri() . '/css/min/drum-machine-app.min.css');
wp_enqueue_script('drum-machine-script', get_template_directory_uri() . '/js/min/drum-machine-app.min.js', array('jquery'), '1.0', true);

// Drum Machine Shortcode

function drum_machine_shortcode() {
    ob_start(); ?>
    <div class="page-drum-machine">
        <div class="drum-machine">
            <div class="controls">
                <div class="drum-pad">
                    <button type="button" id="kick-btn"></button>
                    <label>KICK</label>
                </div>
                <div class="drum-pad">
                    <button type="button" id="snare-btn"></button>
                    <label>SNARE</label>
                </div>
                <div class="drum-pad">
                    <button type="button" id="hihat-btn"></button>
                    <label>HI-HAT</label>
                </div>
            </div>
            <div class="tempo-display">120.0</div>
            <div class="grid" id="sequencer-grid"></div>
            <div class="step-numbers" id="step-numbers">
                <?php for($i = 1; $i <= 16; $i++): ?>
                    <div class="step-number"><?php echo $i; ?></div>
                <?php endfor; ?>
            </div>
            <div class="transport">
                <button id="play-button">PLAY</button>
                <button id="stop-button">STOP</button>
                <button id="clear-button">CLEAR</button>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('drum_machine', 'drum_machine_shortcode');


// Register Custom Post Type
function register_drum_app_post_type() {
    register_post_type('drum_app', array(
        'labels' => array(
            'name' => 'Drum App',
            'singular_name' => 'Drum Sample'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-playlist-audio',
        'supports' => array('title')
    ));
}
add_action('init', 'register_drum_app_post_type');

// Register ACF Fields
function register_drum_app_acf_fields() {
    if(function_exists('acf_add_local_field_group')):
        acf_add_local_field_group(array(
            'key' => 'group_drum_samples',
            'title' => 'Drum Samples',
            'fields' => array(
                array(
                    'key' => 'field_kick_sample',
                    'label' => 'Kick Sample',
                    'name' => 'kick_sample',
                    'type' => 'file',
                    'return_format' => 'url',
                    'mime_types' => 'wav'
                ),
                array(
                    'key' => 'field_snare_sample',
                    'label' => 'Snare Sample',
                    'name' => 'snare_sample', 
                    'type' => 'file',
                    'return_format' => 'url',
                    'mime_types' => 'wav'
                ),
                array(
                    'key' => 'field_hihat_sample',
                    'label' => 'Hi-Hat Sample',
                    'name' => 'hihat_sample',
                    'type' => 'file',
                    'return_format' => 'url',
                    'mime_types' => 'wav'
                )
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'drum_app'
                    )
                )
            )
        ));
    endif;
}
add_action('acf/init', 'register_drum_app_acf_fields');







function enqueue_drum_samples() {
    $latest_samples = get_posts([
        'post_type' => 'drum_app',
        'posts_per_page' => 1
    ]);

    if ($latest_samples) {
        $sample_urls = [
            'kick' => get_field('kick_sample', $latest_samples[0]->ID),
            'snare' => get_field('snare_sample', $latest_samples[0]->ID),
            'hihat' => get_field('hihat_sample', $latest_samples[0]->ID)
        ];

        wp_localize_script('drum-machine-script', 'drumSamples', $sample_urls);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_drum_samples');


function enqueue_drum_machine_assets() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    wp_enqueue_style('drum-machine-styles', $theme_uri . '/css/min/drum-machine-app.min.css');
    wp_enqueue_script('drum-machine-script', $theme_uri . '/js/min/drum-machine-app.min.js', array('jquery'), '1.0', true);

    // Get latest drum samples
    $samples = get_posts([
        'post_type' => 'drum_app',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
    ]);

    if ($samples) {
        $sample_urls = [
            'kick' => get_field('kick_sample', $samples[0]->ID),
            'snare' => get_field('snare_sample', $samples[0]->ID),
            'hihat' => get_field('hihat_sample', $samples[0]->ID)
        ];

        wp_localize_script('drum-machine-script', 'drumSamples', $sample_urls);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_drum_machine_assets');

// Disable add new post since we only need one

function modify_drum_app_capabilities() {
    global $wp_post_types;
    
    $existing_posts = get_posts([
        'post_type' => 'drum_app',
        'posts_per_page' => 1
    ]);
 
    if (!empty($existing_posts)) {
        $wp_post_types['drum_app']->cap->create_posts = 'do_not_allow';
        $wp_post_types['drum_app']->capability_type = 'post';
    }
 }
 add_action('init', 'modify_drum_app_capabilities', 11);