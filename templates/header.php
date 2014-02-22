<?php render_template('head'); ?>

<header class="masthead">
    
    <div class="container">
            
        <div class="row logo-tagline">

            <div class="col-md-12">
                
                <a href="<?php bloginfo('url'); ?>" title="Home">
                    <h2>
                        <img src="<?php echo get_config('site-logo'); ?>" alt="<?php bloginfo('name'); ?>" />
                        <?php bloginfo('name'); ?>
                    </h2>
                </a>

            </div>

        </div>

        <div class="row main-nav">

            <nav class="col-md-12" role="navigation">
            
                <?php wp_nav_menu(array('theme_location' => 'header', 'container' => false)); ?>
                
            </nav>

        </div>
    
    </div>
                
</header>