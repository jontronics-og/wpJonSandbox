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
                <h1><?php the_title(); ?></h1>
                <div class="article-meta">
                    <span>By <?php the_author(); ?></span> • 
                    <span>Published <?php the_date(); ?></span>
                    <?php if (function_exists('get_reading_time')) : ?>
                        • <span><?php echo get_reading_time(); ?></span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="featured-image-container">
                    <?php the_post_thumbnail('full', array('class' => 'featured-image')); ?>
                </div>
            <?php endif; ?>

            <?php if (function_exists('generate_table_of_contents')) : ?>
                <div class="table-of-contents">
                    <h3>Table of Contents</h3>
                    <?php generate_table_of_contents(); ?>
                </div>
            <?php endif; ?>

            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <div class="share-buttons">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" class="share-button">Share on Twitter</a>
                <a href="https://www.linkedin.com/shareArticle?url=<?php echo urlencode(get_permalink()); ?>" class="share-button">Share on LinkedIn</a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" class="share-button">Share on Facebook</a>
            </div>

            <div class="author-box">
                <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', array('class' => 'author-avatar')); ?>
                <div class="author-info">
                    <h3>About <?php the_author(); ?></h3>
                    <p><?php echo get_the_author_meta('description'); ?></p>
                </div>
            </div>

        <?php endwhile; ?>
    </article>
</main>

<?php get_footer(); ?>