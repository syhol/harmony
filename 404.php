<?php
/**
 * 404 Page
 *
 * Uses default headers and footers with a full width 12 col content
 * Template used when a route is not matched or content is not found in 
 * the database
 */

render_template('header'); ?>

<div class="container">

    <div class="row">

        <section class="col-md-9">
        
            <?php render_template('single-item'); ?>
        
        </section>

        <section class="col-md-3">

            <?php render_template('sidebar'); ?>
        
        </section>
    </div>

</div>

<?php render_template('footer'); ?>