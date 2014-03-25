<?php
/**
 * Home Page
 * 
 * Uses default headers and footers with a full width 12 col content 
 * Template used as the front page
 * 
 * Template Name: Home
 * 
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */

render_template('header'); ?>

<div class="container">

    <div class="row">
        
        <section class="col-md-12">
        
            <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

                <?php render_template('single-item'); ?>

            <?php endwhile; endif; ?>

        </section>
    
    </div>

</div>

<?php render_template('footer'); ?>