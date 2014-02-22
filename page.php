<?php
/**
 * Default Page
 * 
 * Uses default headers and footers with a 9 col content and a 3 col sidebar
 * Template used for pages
 */

render_template('header'); ?>

<div class="container">

	<div class="row">
		
		<section class="col-md-9">
		
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			
				<header>
				
					<h1><?php the_title(); ?></h1>
					
				</header>
				
				<article <?php post_class(); ?>>
				
					<?php the_content(); ?>
				
				</article>
							
			<?php endwhile; endif; ?>
		
		</section>

		<?php render_template('sidebar'); ?>
	
	</div>

</div>

<?php render_template('footer'); ?>