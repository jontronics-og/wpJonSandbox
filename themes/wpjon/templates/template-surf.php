<?php 
/* 
Template Name: Surf App
Template Post Type: post
*/




get_header(); ?>

<main class="surf-template-main-content">
    <?php while (have_posts()) : the_post(); ?>
        <!-- Main Content Column -->
        <article class="surf-template-blog-post">
            <!-- Breadcrumb Navigation -->
            <div class="surf-template-breadcrumb-nav">
                <a href="<?php echo home_url('/#latest-insights'); ?>">
                    <span class="surf-template-arrow">←</span> Latest Insights & Projects
                </a>
            </div>

            <!-- Title Section -->
            <h1 class="surf-template-title"><?php the_title(); ?></h1>
            
            <!-- Meta Section -->
            <div class="surf-template-meta">
                <span>By <?php 
                $author_email = get_the_author_meta('email');
                if($author_email === 'jon.wordpress.dev@gmail.com') {
                    echo 'Jonathan Aquarone';
                } else {
                    echo esc_html(get_the_author_meta('display_name'));
                }
                ?></span>
                <span>•</span>
            </div>

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="surf-template-featured-image-wrapper">
                    <?php the_post_thumbnail('full', array('class' => 'surf-template-featured-image')); ?>
                </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="surf-template-post-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>