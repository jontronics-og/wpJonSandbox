<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="page" class="site">
        <header class="wpj-header">
            <div class="wpj-header-container">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="wpj-logo">
                    wpJon
                </a>
                
                <nav class="wpj-main-nav">
                    <?php 
                        wp_nav_menu(array(
                            'theme_location' => 'wp_jon_main_menu',
                            'depth' => 2,
                            'container' => false,
                            'menu_class' => 'wpj-nav-links',
                            'fallback_cb' => false
                        ));
                    ?>
                </nav>

                <div class="wpj-header-actions">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="wpj-action-btn">Let's Talk</a>
                    <button class="wpj-mobile-menu-toggle" aria-label="Toggle menu">
                        <span class="hamburger-lines"></span>
                    </button>
                </div>
            </div>

            <div class="wpj-mobile-menu">
                <button class="close-menu" aria-label="Close menu">×</button>
                <div class="wpj-mobile-menu-content">
    <?php wp_nav_menu(array(
        'theme_location' => 'wp_jon_main_menu',
        'depth' => 2,
        'container' => false,
        'menu_class' => 'wpj-mobile-nav-links',
        'fallback_cb' => false
    )); ?>
    <div class="wpj-mobile-cta-group">
        <a href="tel:+13474320497" class="wpj-mobile-cta-button">
            <i class="fa-solid fa-phone"></i>
            Let's Talk
        </a>
        <a href="<?php echo esc_url(wp_get_upload_dir()['baseurl'] . '/2024/12/Jonathan-Aquarone-Resume.pdf'); ?>" 
           class="wpj-mobile-cta-button wpj-mobile-cta-secondary" 
           download>
            <i class="fa-solid fa-download"></i>
            DL Resume
        </a>
    </div>
</div>
            </div>
        </header>