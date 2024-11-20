
<?php get_header()?>
        <div id="content" class="site-content">
            <div id="primary" class="site-area">
                <main id="main" class="site-main">
                    
                <?php 
                    $hero_title = get_theme_mod( 'set_hero_title', 'Please, type some title' );
                    $hero_subtitle = get_theme_mod( 'set_hero_subtitle', 'Please, type some subtitle' );
                    $hero_button_link = get_theme_mod( 'set_hero_button_link', '#' );
                    $hero_button_text = get_theme_mod( 'set_hero_button_text', 'Learn More' );
                    $hero_height = get_theme_mod( 'set_hero_height', 800 );
                    $hero_background = wp_get_attachment_url( get_theme_mod( 'set_hero_background' ) );
                    ?>
                    <section class="hero" style="background-image: url('<?php echo $hero_background ?>');">
                        <div class="overlay" style="min-height: <?php echo $hero_height ?>px">
                            <div class="container">
                                <div class="hero-items">
                                    <h1><?php echo $hero_title; ?></h1>
                                    <p><?php echo nl2br( $hero_subtitle ); ?></p>
                                    <a href="<?php echo $hero_button_link ?>"><?php echo $hero_button_text; ?></a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="services">
                        <h2>Services</h2>
                        <div class="container">
                            <div class="services-item">
                                <?php 
                                    if( is_active_sidebar( 'services-1' )){
                                        dynamic_sidebar( 'services-1' );
                                    }
                                ?>
                            </div>
                            <div class="services-item">
                                <?php 
                                    if( is_active_sidebar( 'services-2' )){
                                        dynamic_sidebar( 'services-2' );
                                    }
                                ?>
                            </div>
                            <div class="services-item">
                                <?php 
                                    if( is_active_sidebar( 'services-3' )){
                                        dynamic_sidebar( 'services-3' );
                                    }
                                ?>
                            </div>
                        </div>
                    </section>
                    
                    <section class="home-blog">
                        <h2>Featured Posts</h2>
                        <div class="container">
                            <?php 

                            $args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 5,
                                'category__in'  => array( 4, 5, 6 ),
                                'category__not_in' => array( 1 )
                            );

                            $postlist = new WP_Query( $args );

                                if( $postlist->have_posts() ):
                                    while( $postlist->have_posts() ) : $postlist->the_post();
                                    ?>
                                    <article class="latest-news">
                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <div class="meta-info">
                                        <p>
                                            by <span><?php the_author_posts_link(); ?></span> 
                                            Categories: <span><?php the_category( ' ' ); ?></span>
                                            Tags: <?php the_tags( '', ', ' ); ?>
                                        </p>
                                        <p><span><?php echo get_the_date(); ?></p>
                                        </div>
                                        <?php the_excerpt(); ?>
                                    </article>
                                    <?php
                                    endwhile;
                                    wp_reset_postdata();
                                else: ?>
                                    <p>Nothing yet to be displayed!</p>
                            <?php endif; ?>                                
                        </div>
                    </section>
                    
                </main>
            </div>
        </div>
    </div>

    <main>
        <?php echo "Hello World"; ?>  
    </main>
    <?php get_footer()?>
   