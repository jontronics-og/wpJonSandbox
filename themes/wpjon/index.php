<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <div id="page" class="site">
        
        <header>
            <section class="top-bar">
                <div class="logo">
                    Logo goes here
                </div>
                <div class="searchbox">
                    Search box goes here
                </div>
            </section>

            <section class="menu-area">
                <nav class="main-menu">
                    Navigation menu goes here
                </nav>
            </section>
        </header>

        <div id="content" class="site-content">
            <div id="primary" class="site-area">
                <main id="main" class="site-main">
                    
                    <section class="hero">
                        Hero section content
                    </section>
                    
                    <section class="services">
                        Services section content
                    </section>
                    
                    <section class="home-blog">
                        Home blog section content
                    </section>
                    
                </main>
            </div>
        </div>
    </div>

    <main>
        <?php echo "Hello World"; ?>  
    </main>

    <footer class="site-footer">
        <!-- Footer content here -->
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
