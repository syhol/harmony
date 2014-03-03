<?php 
/**
 * Header Template
 * 
 * Opens the html and body tag, runds the wp_head section inside the head tags,
 * and renders the default header markup for the site
 */

render_template('header/head'); ?>

<header class="masthead">
    
    <div class="container">
            
        <?php render_template('header/logo-title'); ?>

        <?php render_template('header/nav'); ?>
    
    </div>
                
</header>