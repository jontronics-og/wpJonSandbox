<?php get_header(); ?>

<main class="main-content">
    <?php while (have_posts()) : the_post(); ?>
        <!-- Main Content Column -->
        <article class="blog-post">
            <!-- Breadcrumb Navigation -->
            <div class="breadcrumb-nav">
                <a href="<?php echo home_url('/#latest-insights'); ?>">
                    <span class="arrow">←</span> Latest Insights & Projects
                </a>
            </div>

            <!-- Title Section -->
            <h1 class="blog-title"><?php the_title(); ?></h1>
            
            <!-- Meta Section -->
          
            <div class="post-meta">
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
                <div class="featured-image-wrapper">
                    <?php the_post_thumbnail('full', array('class' => 'featured-image')); ?>
                </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="post-content">
                <?php the_content(); ?>
            </div>
        </article>

        <!-- Sidebar Column -->
        <aside class="sidebar">
            <!-- Your sticky sidebar content will go here -->
        </aside>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>