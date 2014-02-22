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
				
					<h1><?php the_title(); ?></h1>
					
				</header>
				
				<article <?php post_class(); ?>>
					
					<?php the_content(); ?>


					<a class="btn btn-default" href="#"><span class="glyphicon glyphicon-align-left"></span></a>
           			<a class="btn btn-default" href="#"><i class="fa fa-align-left"></i></a>

           			</br>

           			<a class="btn btn-default" href="#"><span class="glyphicon glyphicon-align-center"></span></a>
           			<a class="btn btn-default" href="#"><i class="fa fa-align-center"></i></a>

           			</br>
           			
           			<a class="btn btn-default" href="#"><span class="glyphicon glyphicon-align-right"></span></a>
           			<a class="btn btn-default" href="#"><i class="fa fa-align-right"></i></a>
					
					<?php 

					global $theme_config;
					set_config('this.is.a.multidimentional.array', 'yay');
					var_dump($theme_config);
					var_dump(get_config('this.is.a.multidimentional', 'yay'));

					$subject = 'hello, this is my string, my string says hello, would you like to say hello back?';
					var_dump(str_replace_first('hello', 'HELLO', $subject));
					var_dump(str_replace_last('hello', 'HELLO', $subject));
					var_dump(str_replace('hello', 'HELLO', $subject));

					$subject = 'This is some Awesome!';
					var_dump(snake_case($subject));
					var_dump(camel_case($subject));
					var_dump(camel_case($subject, true));
					var_dump(remove_camel_case(camel_case($subject)));
					var_dump(prettify_string(snake_case($subject)));

					?>

				</article>
							
			<?php endwhile; endif; ?>
		
		</section>
	
	</div>

</div>

<?php render_template('footer') ?>