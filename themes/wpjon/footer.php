<footer class="site-footer">

        <div class="container">
            <div class="copyright">
                Copyright x - Al rights reserved
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
