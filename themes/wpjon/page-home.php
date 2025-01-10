<?php
/*
Template Name: Home Page
*/

get_header(); ?>

<!-- Hero Section -->
<section class="hero-section">
    <!-- Background Dots -->
    <div class="hero-background">
        <div class="dot-grid"></div>
    </div>

    <!-- Hero Content -->
    <div class="hero-wrapper">
        <!-- Left Section -->
        <div class="hero-left">
            <div class="content-box">
                <div class="hero-container">
                    <h1 class="hero-title">Crafting 
                        <span class="wave-text">
                            <span class="wave-letter-hero">E</span>
                            <span class="wave-letter-hero">x</span>
                            <span class="wave-letter-hero">c</span>
                            <span class="wave-letter-hero">e</span>
                            <span class="wave-letter-hero">p</span>
                            <span class="wave-letter-hero">t</span>
                            <span class="wave-letter-hero">i</span>
                            <span class="wave-letter-hero">o</span>
                            <span class="wave-letter-hero">n</span>
                            <span class="wave-letter-hero">a</span>
                            <span class="wave-letter-hero">l</span>
                        </span> 
                        WordPress Experiences</h1>
                    <h2 class="hero-subtitle">Enhancing Your Digital Presence with Custom WordPress Solutions</h2>
                    <div class="button-group">
                        <a href="tel:+13474320497" class="cta-button">
                            <i class="fa-solid fa-phone"></i>
                            Let's Talk
                        </a>
                        <a href="<?php echo esc_url(wp_get_upload_dir()['baseurl'] . '/2024/12/Jonathan-Aquarone-Resume.pdf'); ?>" 
                           class="cta-button cta-button-secondary" 
                           download>
                            <i class="fa-solid fa-download"></i>
                            DL Resume
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="hero-right">
            <div class="services-container">
                <!-- Center Card -->
                <div class="card-container">
                    <div class="card">
                        <div class="center-dots-container">
                            <?php for ($i = 0; $i < 9; $i++) : ?>
                                <div class="center-dot"></div>
                            <?php endfor; ?>
                        </div>
                        <div class="brand-text">wpJon</div>
                    </div>
                </div>

                <!-- Service Icons -->
                <?php
                $services = [
                    'rds' => [
                        'icon' => 'http://wpjon.wpenginepowered.com/wp-content/uploads/2024/11/web-design.png',
                        'label' => 'UX/UI Design'
                    ],
                    'ec2' => [
                        'icon' => 'http://wpjon.wpenginepowered.com/wp-content/uploads/2024/11/seo.png',
                        'label' => 'Technical SEO'
                    ],
                    's3' => [
                        'icon' => 'http://wpjon.wpenginepowered.com/wp-content/uploads/2024/11/data.png',
                        'label' => 'WordPress Development'
                    ],
                    'lambda' => [
                        'icon' => 'http://wpjon.wpenginepowered.com/wp-content/uploads/2024/11/customer-support.png',
                        'label' => 'Support'
                    ],
                    'cloudwatch' => [
                        'icon' => 'http://wpjon.wpenginepowered.com/wp-content/uploads/2024/11/project-management.png',
                        'label' => 'Project Management'
                    ]
                ];

                foreach ($services as $id => $service) : ?>
                    <div id="<?php echo esc_attr($id); ?>" class="service-icon">
                        <div class="icon-circle">
                            <svg class="circle-path">
                                <circle cx="41" cy="41" r="40"></circle>
                            </svg>
                            <div class="support-icon">
                                <img src="<?php echo esc_url($service['icon']); ?>" 
                                     alt="<?php echo esc_attr($service['label']); ?> Icon">
                            </div>
                            <div class="check-mark">✓</div>
                        </div>
                        <div class="service-label"><?php echo esc_html($service['label']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<div class="container">
   <div class="header">
   <h2>Latest Insights & Projects</h2>
   <p>Dive into my journey as a WordPress developer through technical deep-dives, project case studies, and development best practices. Here I share my hands-on experience building scalable WordPress solutions and tackling real-world development challenges.</p>
       <div class="tag active" data-category-id="10">All</div>
       <div class="tag" data-category-id="7">Wordpress Development</div>
       <div class="tag" data-category-id="9">UX/UI</div>
       <div class="tag" data-category-id="8">Technical SEO</div>
   </div>
   <div id="card-grid" class="grid">
   </div>
</div>











<?php
$args = array(
    'post_type' => 'workwork',
    'post__in' => array(87, 89),    // Specific post IDs
    'orderby' => 'post__in',        // Maintain the exact order specified
    'posts_per_page' => 2           // Show only 2 posts
);
$work_query = new WP_Query($args);
?>

<div class="cw-container">
   <div class="header">
       <h2>Enterprise WordPress Solutions</h2>
       <p>Discover a collection of enterprise-level WordPress websites I engineered and maintained for leading organizations. These projects showcase my expertise in developing custom themes, optimizing performance, and ensuring seamless functionality for high-traffic business platforms.</p>
   </div>
   <div class="cw-grid">
       <?php 
       if($work_query->have_posts()) : 
           while($work_query->have_posts()) : $work_query->the_post();
               $image = get_field('upload_image');
               $work_url = get_field('link_to_work_site');
       ?>
           <a href="<?php echo esc_url($work_url); ?>" class="cw-card" target="_blank">
               <?php if($image) : ?>
               <div class="cw-card-image">
                   <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
               </div>
               <?php endif; ?>

               <div class="cw-card-content">
                   <h3 class="cw-card-title"><?php the_title(); ?></h3>
                   <span class="cw-read-more">View Website</span>
               </div>
           </a>
       <?php 
           endwhile;
           wp_reset_postdata();
       endif; 
       ?>
   </div>
</div>
<?php ?>

<?php
$args = array(
   'post_type' => 'workwork',
   'post__in' => array(91, 92, 96, 98),    // Specific post IDs
   'orderby' => 'post__in',        // Maintain the exact order specified
   'posts_per_page' => 4           // Show only 4 posts
);

$work_query = new WP_Query($args);
?>

<div class="cw-container">
   <div class="header">
       <h2>Building Unique WordPress Experiences for Startups, Small Business Sites & Personal Sandbox Testing sites.</h2>
       <p>Explore a collection of WordPress websites I engineered and maintained for small businesses, startups, and personal projects. These examples showcase my expertise in developing custom themes, optimizing performance, and creating scalable solutions for diverse business needs and testing environments.</p>
   </div>
   <div class="cw-grid">
       <?php 
       if($work_query->have_posts()) : 
           while($work_query->have_posts()) : $work_query->the_post();
               $image = get_field('upload_image');
               $work_url = get_field('link_to_work_site');
       ?>
           <a href="<?php echo esc_url($work_url); ?>" class="cw-card" target="_blank">
               <?php if($image) : ?>
               <div class="cw-card-image">
                   <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
               </div>
               <?php endif; ?>

               <div class="cw-card-content">
                   <h3 class="cw-card-title"><?php the_title(); ?></h3>
                   <span class="cw-read-more">View Website</span>
               </div>
           </a>
       <?php 
           endwhile;
           wp_reset_postdata();
       endif; 
       ?>
   </div>
</div>
<?php ?>




















<section class="testimonials-section">
    <div class="dot-background"></div>
    <div class="testimonials-content">
        <h2>Trusted by Leaders</h2>
        <p>See what co-workers, managers, executives and clients have to say about my expertise and collaborative approach.</p>
        
        <div class="testimonial-card">
            <div class="testimonial-text">
                <blockquote></blockquote>
            </div>
            <div class="testimonial-author">
                <div class="author-info">
                    <div class="author-details">
                        <h3 class="details"></h3>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Services Section -->
<!-- <section class="services">
    <div class="container">
        
        <?php /* if (is_active_sidebar('services-1')) : ?>
            <div class="services-item">
                <?php dynamic_sidebar('services-1'); ?>
            </div>
        <?php endif; ?>

        <?php if (is_active_sidebar('services-2')) : ?>
            <div class="services-item">
                <?php dynamic_sidebar('services-2'); ?>
            </div>
        <?php endif; ?>

        <?php if (is_active_sidebar('services-3')) : ?>
            <div class="services-item">
                <?php dynamic_sidebar('services-3'); ?>
            </div>
        <?php endif;*/ ?>
    </div>
</section> -->

<!-- Blog Section -->
<?php /*
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 5,
    'category__in' => array(4, 5, 6),
    'category__not_in' => array(1)
);

$recent_posts = new WP_Query($args);

if ($recent_posts->have_posts()) : ?>
    <section class="home-blog">
        <h2>Featured Posts</h2>
        <div class="container">
            <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                <article class="latest-news">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large'); ?>
                        </a>
                    <?php endif; ?>
                    
                    <h3>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    
                    <div class="meta-info">
                        <p>
                            by <span><?php the_author_posts_link(); ?></span>
                            Categories: <span><?php the_category(' '); ?></span>
                            <?php if (has_tag()) : ?>
                                Tags: <?php the_tags('', ', '); ?>
                            <?php endif; ?>
                        </p>
                        <p><span><?php echo get_the_date(); ?></span></p>
                    </div>
                    
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php 
    wp_reset_postdata();
endif; */ ?> 

<?php get_footer(); ?>