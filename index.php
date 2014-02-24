<?php
/**
 * Index Page
 *
 * Uses default headers and footers with a 9 col content and a 3 col sidebar
 * Template for the post index and fallback/default template for other post type
 * indexs. Ultimate fallback for all routes.
 */

render_template('header'); ?>

<div class="container">

    <div class="row">
        
        <section class="col-md-9">
        
            <header>

                <h1><?php //Need an archive title function ?></h1>

            </header>
        
            <?php if (have_posts()) : ?>

                <?php while(have_posts()) : the_post(); ?>

                    <?php render_template('index-item', get_post_index_data); ?>
                    
                <?php endwhile; ?>
                
                <footer>
                    
                    <?php //Need to build paginations function ?>
                        
                </footer>
                
            <?php else: ?>
                
                <article>
                    
                    <p>No results were found.</p>
                
                </article><!-- #post-0 -->
                        
            <?php endif; ?>
        
        </section>

        <?php render_template('sidebar'); ?>
    
    </div>

</div>

<?php render_template('footer'); ?>