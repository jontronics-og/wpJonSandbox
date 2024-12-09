<?php
/**
 * Template Name: Single Blog Post
 * 
 * This is the template that displays single blog posts.
 */

get_header(); ?>

<main class="main-content">
    <article>
        <?php
        while ( have_posts() ) :
            the_post();
        ?>
            <header class="article-header">
                <h1 class="single-blog"><?php the_title(); ?></h1>
                <div class="article-meta">
                    <span>By <?php the_author(); ?></span> 
                    
                    <?php if (function_exists('get_reading_time')) : ?>
                        • <span><?php echo get_reading_time(); ?></span>
                    <?php endif; ?>
                </div>
                <div class="share-buttons">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" class="share-button">Share on Twitter</a>
    
                 </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="featured-image-container">
                    <?php the_post_thumbnail('full', array('class' => 'featured-image')); ?>
                </div>
            <?php endif; ?>


            <div class="post-content">
                <?php the_content(); ?>
            </div>

            


        <?php endwhile; ?>
    </article>
</main>

<?php get_footer(); ?>