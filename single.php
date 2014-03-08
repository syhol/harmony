<?php
/**
 * Default Single
 * 
 * Uses default headers and footers with a 9 col content and a 3 col sidebar
 * Will always be the single for the 'post' post type and will act as a 
 * fallback/default single template for all other post types
 * 
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */

render_template('header'); ?>

<div class="container">

	<div class="row">
		
		<section class="col-md-9">

			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

				<?php render_template('single-item'); ?>

			<?php endwhile; endif; ?>
		
		</section>

		<section class="col-md-3 sidebar">

			<?php render_template('sidebar'); ?>
		
		</section>
	
	</div>

</div>

<?php render_template('footer'); ?>