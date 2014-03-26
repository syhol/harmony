<?php
/**
 * Index Page
 *
 * Uses default headers and footers with a 9 col content and a 3 col sidebar
 * Template for the post index and fallback/default template for other post type
 * indexs. Ultimate fallback for all routes.
 * 
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */

render_template('header'); ?>

<div class="container">

	<div class="row">
		
		<section class="col-md-9">

			<header>

				<h1><?php page_title() ?></h1>

			</header>
					
			<?php if (have_posts()) : ?>

				<?php while(have_posts()) : the_post(); ?>

					<?php render_template('index-item'); ?>
					
				<?php endwhile; ?>
				
				<footer>
					
					<?php // Pagination module needed ?>
					
				</footer>
				
			<?php else: ?>
				
				<article>
					
					<p>No results were found.</p>
				
				</article><!-- #post-0 -->
						
			<?php endif; ?>

		</section>

		<section class="col-md-3">

			<?php render_template('sidebar'); ?>
		
		</section>
	
	</div>

</div>

<?php render_template('footer'); ?>