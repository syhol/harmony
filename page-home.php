<?php
/**
 * Home Page
 * 
 * Uses default headers and footers with a full width 12 col content 
 * Template used as the front page
 * 
 * Template Name: Home
 */

render_template('header'); ?>

<div class="container">

	<div class="row">
		
		<section class="col-md-12">
		
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			
				<header>
				
					<h1><?php page_title(); ?></h1>
					
				</header>
				
				<article <?php post_class(); ?>>
					
					<?php the_content(); ?>

				</article>
							
			<?php endwhile; endif; ?>
		
		</section>
	
	</div>

</div>

<?php render_template('footer') ?>