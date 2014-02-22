
<footer class="mastfoot text-center">
    
    <div class="container">
        
        <div class="row">
        
            <div class="md-col-12 footer-nav">
            
                <?php wp_nav_menu(array('theme_location' => 'footer', 'container' => false)); ?>

            </div>
            
        </div>        

        <div class="row">
        
            <div class="md-col-12">
            
                <p class="copyright">&copy; Copyright <?php echo date('Y') . ' ' . get_bloginfo('name'); ?>.</p>

            </div>
        
        </div>
    
    </div>
        
</footer>

<?php render_template('foot'); ?>