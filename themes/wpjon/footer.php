<footer class="site-footer">

        <div class="container">
            <div class="copyright">
                <p> <?php echo get_theme_mod('set_copyright', 'Copyright x - All Rights Reserved'); ?></p>
            </div>
                <div class="footer-menu">
                    <?php wp_nav_menu( array( 
                        
                        'theme_location' => 'wp_jon_footer_menu',
                        'depth' => 1
                        
                    )); ?>
                </div>
            </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
