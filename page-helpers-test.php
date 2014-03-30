<?php
/**
 * Helpers Test
 * 
 * Tests the php helpers and wp helpers
 * 
 * Template Name: Helpers Test
 * 
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */

render_template('header'); ?>

<div class="container">

	<div class="row">

		<section class="col-sm-10 col-sm-offset-1">
	  
		<h1 class="text-center"><?php page_title(); ?></h1>

			<hr>

			<h3>Sorcery</h3>
			
			<h4>Widgets</h4>
			
			<label>Textbox</label>

			<?php 
			sorcery_widget_text('My Text', 'value');
			?>
			
			<label>Textarea</label>

			<?php 
			sorcery_widget_textarea('My Textarea', 'value ipsum');
			?>

			<label>Radio Button</label>

			<?php 
			sorcery_widget_radio('My Radio', 'one');
			sorcery_widget_radio('My Radio', 'two', true);
			sorcery_widget_radio('My Radio', 'three');
			?>

			<?php 
			$radio = new Sorcery_Widget_Checkbox('tasks', 'Taken out the trash');
			$radio['attributes.data-trash'] = 'taken-out';
			echo $radio;
			?>

			<label>Checkbox</label>

			<?php 
			sorcery_widget_checkbox('My Check','one', true);
			sorcery_widget_checkbox('My Check', 'two');
			sorcery_widget_checkbox('My Check', 'three', true);
			?>

			<label>Select</label>

			<?php 
			sorcery_widget_select('My Select', 'six', array(
				'one' => 'One',
				'two' => 'Two',
				'three' => 'Three',
				'Four' => array(
					'five' => 'Five',
					'six' => 'Six',
					'seven' => 'Seven'
				)
			));
			?>

			<hr>

			<h3>Profiler</h3>
			
			<?php

			ob_start();

			$diffs1 = array();
			for ($i = 1; $i < 100; $i++) {
				profile_start(); 
				$single_item = render_template('single-item', array('content' => 'look at me!'), true);
				echo $single_item;
				$profile = profile_stop();
				$diffs1[] = $profile['time-diff'];
			}

			$diffs2 = array();
			for ($i = 1; $i < 100; $i++) {
				profile_start(); 
				render_template('single-item', array('content' => 'look at me!'));
				$profile = profile_stop();
				$diffs2[] = $profile['time-diff'];
			}

			ob_end_clean();

			var_dump(array_sum($diffs1) / count($diffs1));
			var_dump(array_sum($diffs2) / count($diffs2));

			?>

			<hr>

			<h3>Render Template</h3>
			
			<p>
				Render a template using data from the 
				data-bindings.php file
			</p>
			<div class="well">
				<?php render_template('single-item'); ?>
			</div>
			<div class="well">
				<?php render_template('index-item'); ?>
			</div>

			<p>
				Render a template overriding data from the 
				data-bindings.php file to make an all new 
				element using the same markup or just tweak the content
			</p>
			<div class="well">
				<?php render_template('single-item', array(
					'classes' => 'jumbotron',
					'title' => 'OMG It\'s Jumbo',
					'content' => '<p>Love the jumbo, im just a standard jumbo paragraph.</p>' .
							 '<p>Using the same template as the content above, but using different injected values.</p>'
				)); ?>
			</div>

			<div class="well">
				<?php render_template('index-item', array('title' => get_the_title() . ' With Some Extras!')); ?>
			</div>

			<p>
				Using some smart logic in the binding file means you can 
				easily override data without having to rewrite everything
				e.g. swap the current post object for another
			</p>
			<div class="well">
				<?php render_template('index-item', array('post' => get_post(1))); ?>
			</div>
			
			<p>
				Oh and you can return compiled templates as strings too
			</p>
			<div class="well">
				<?php $single_item = compile_template('single-item', array('content' => 'look at me!')); ?>
				<pre><?php echo htmlentities($single_item); ?></pre>
			</div>

			<p>
				And use compiled template in other templates
			</p>
			
			<div class="well">
				<?php $index_item = compile_template('index-item'); ?>
				<?php render_template('single-item', array('content' => $index_item)); ?>
			</div>

			<hr>

			<h3>Page Title</h3>
			
			<p>
				Render it: <?php page_title(); ?>
			</p>

			<p>
				Return it:
				<?php var_dump(get_page_title()); ?>
			</p>

			<?php
			$month_query = new WP_Query(array(
				'monthnum' => 8
			)); 
			$author_query = new WP_Query(array(
				'author_name' => 'sholloway'
			));
			$tag_query = new WP_Query(array(
				'tag' => 'training'
			)); 
			$search_query = new WP_Query(array(
				's' => 'Keyword Search'
			)); 
			?>

			<p>
				Custom queries:
				<h5><?php page_title($month_query); ?></h5>
				<h5><?php page_title($author_query); ?></h5>
				<h5><?php page_title($tag_query); ?></h5>
				<h5><?php page_title($search_query); ?></h5>
			</p>

			<hr>

			<h3>Registry</h3>

			<?php 
			$original_logo = 'https://cdn3.iconfinder.com/data/icons/free-social-icons/67/wordpress_square-128.png';
			$alt_logo = 'http://speckycdn.sdm.netdna-cdn.com/wp-content/uploads/2013/09/25-40-flat-logos.png'; 
			?>

			<p>
				Global data store where individual items or the entire data 
				container can be swapped out at a moments notice, useful for 
				storing application runtime values/object/variables.
			</p>

			<p>Get a registry value</p>
			<p><img src="<?php echo get_registry('site-logo'); ?>" /></p>

			<p>Edit a registry value</p>
			<?php set_registry('site-logo', $alt_logo); ?>
			<p><img src="<?php echo get_registry('site-logo'); ?>" /></p>

			<p>And back again</p>
			<?php set_registry('site-logo', $original_logo); ?>
			<p><img src="<?php echo get_registry('site-logo'); ?>" /></p>

			<p>Swap out the entire register container for new registry values throughout</p>
			<?php $old_registry = registry_container(array('site-logo' => $alt_logo)); ?>
			<p><img src="<?php echo get_registry('site-logo'); ?>" /></p>

			<p>Then re-inject old container back in to return to the old state</p>
			<?php registry_container($old_registry); ?>
			<p><img src="<?php echo get_registry('site-logo'); ?>" /></p>
			<h3>Location Helpers</h3>
			
			<ul>
				<li>get_route: <?php echo get_route('to/my/route'); ?></li>
				<li>get_theme_url: <?php echo get_theme_url('to/my/resource.js'); ?></li>
				<li>get_theme_path: <?php echo get_theme_path('to/my/resource.php'); ?></li>
				<li>get_asset_url: <?php echo get_asset_url('js/resource.js'); ?></li>
				<li>get_asset_path: <?php echo get_asset_path('php/resource.php'); ?></li>
				<li>get_template_url: <?php echo get_template_url('single/template.php'); ?></li>
				<li>get_template_path: <?php echo get_template_path('single/template.php'); ?></li>
				<li>get_function_url: <?php echo get_function_url('core/funcs.php'); ?></li>
				<li>get_function_path: <?php echo get_function_path('custom/funcs.php'); ?></li>
				<li>get_module_url: <?php echo get_module_url('my-module/resource.js'); ?></li>
				<li>get_module_path: <?php echo get_module_path('my-module/resource.php'); ?></li>
			</ul>

			<?php 

			$array = array(
				'array-first-key' => 'array-first-value',
				'and' => array(
					'this' => array(
						'is' => 'multidimensional',
						'where',
						'we',
						'getting' => 'freaky',
					)
				),
				'array-last-key' => 'array-last-value',
			);

			?>

			<hr>

			<h3>Test Array</h3>

			<p><?php var_dump($array); ?></p>


			<hr>

			<h3>Array Dot Get/Set<small>- array_dot_get(), array_dot_set()</small></h3>


			<p>
				Get <code>"and.this"</code>:
				<?php var_dump(array_dot_get($array, 'and.this')); ?>
			</p>

			<p>
				Get <code>"and.this.is"</code>:
				<?php var_dump(array_dot_get($array, 'and.this.is')); ?>
			</p>

			<p>
				Add an array to <code>"and.this.new"</code><br>
				Get <code>"and.this"</code>:
				<?php array_dot_set($array, 'and.this.new', array('well', 'how', 'about', 'that')); ?>
				<?php var_dump(array_dot_get($array, 'and.this')); ?>
			</p>

			<hr>

			<h3>Array Get First/Last<small>- array_get_first(), array_get_last()</small></h3>

			<?php $first = array_get_first($array); ?>
			<?php $last = array_get_last($array); ?>

			<p>First array key: <?php var_dump($first); ?></p>
			<p>First array value: <?php var_dump($array[$first]); ?></p>
			<p>Last array key: <?php var_dump($last); ?></p>
			<p>Last array value: <?php var_dump($array[$last]); ?></p>

			<h3>Array Is First/Last<small>- array_is_first(), array_is_last()</small></h3>

			<hr>

			<p>
				Is <code>"<?php echo $first; ?>"</code> first
				<?php var_dump(array_is_first($array, $first)); ?>
			</p>
			<p>
				Is <code>"<?php echo $last; ?>"</code> first
				<?php var_dump(array_is_first($array, $last)); ?>
			</p>

			<p>
				Is <code>"<?php echo $first; ?>"</code> last
				<?php var_dump(array_is_last($array, $first)); ?>
			</p>
			<p>
				Is <code>"<?php echo $last; ?>"</code> last
				<?php var_dump(array_is_last($array, $last)); ?>
			</p>

			<hr>

			<h3>Explode by multiple delimiters <small>- explode_multiple()</small></h3>

			<?php 
			$delimiters = array('://', '.', '/', '?', '=');
			$subject = 'http://www.google.com/seg1/seg2?query1=test';
			?>

			<p>
				Explode <code>"<?php echo $subject; ?>"</code> by <code>"<?php echo implode('"</code> and <code>"', $delimiters); ?>"</code>:
				<?php var_dump(explode_multiple($delimiters, $subject)); ?>
			</p>

			<hr>

			<?php 

			$string = 'Hello, My name is Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet.';

			?>

			<hr>

			<h3>Test String</h3>

			<p><?php echo $string ?></p>

			<hr>

			<h3>Text Replace First/Last<small>- str_replace_first(), str_replace_last()</small></h3>

			<p>
				Replace First <code>"Lorem ipsum"</code> with <code>"Simon Holloway"</code>
				<?php var_dump(str_replace_first('Lorem ipsum', 'Simon Holloway', $string)); ?>
			</p>

			<p>
				Replace Last <code>"Lorem ipsum"</code> with <code>"Simon Holloway"</code>
				<?php var_dump(str_replace_last('Lorem ipsum', 'Simon Holloway', $string)); ?>
			</p>


			<hr>

			<h3>Check for strings within strings <small>- str_contains()</small></h3>

			<p>
				Ipsum contains <code>"Lorem"</code>:
				<?php var_dump(str_contains($string, 'Lorem')); ?>
			</p>
			<p>
				Ipsum contains <code>"ipsum"</code> or <code>"not-in-string"</code>:
				<?php var_dump(str_contains($string, array('ipsum', 'not-in-string'))); ?>
			</p>
			
			<p>
				Ipsum contains <code>"not-in-string"</code> or <code>"still-not-in-string"</code>:
				<?php var_dump(str_contains($string, array('not-in-string', 'still-not-in-string'))); ?>
			</p>
			
			<hr>

			<h3>Random String Generation <small>- str_random()</small></h3>

			<p>
				Random string of 16 characters:
				<?php var_dump(str_random()); ?>
			</p>
			<p>
				Random string of 4 characters:
				<?php var_dump(str_random(4)); ?>
			</p>
			<p>
				Random string of 24 characters:
				<?php var_dump(str_random(24)); ?>
			</p>

			<hr>

			<h3>Text Truncation <small>- str_limit(), str_limit_words()</small></h3>

			<p>
				Limit to 43 characters, to the nearest word, ending in <code>"..."</code>:
				<?php var_dump(str_limit($string, 43)); ?>
			</p>
			<p>
				Limit to 43 characters, to the nearest word, ending in <code>"... More >"</code>:
				<?php var_dump(str_limit($string, 43, '... More >')); ?>
			</p>
			<p>
				Limit to 43 characters, NOT to the nearest word, ending in <code>"... More >"</code>:
				<?php var_dump(str_limit($string, 43, '... More >', false)); ?>
			</p>
			<p>
				Limit to 43 characters, NOT to the nearest word, with NO ending:
				<?php var_dump(str_limit($string, 43, '', false)); ?>
			</p>
			<p>
				Limit to 10 words, ending in <code>"... More >"</code>:
				<?php var_dump(str_limit_words($string, 10, '... More >')); ?>
			</p>


			<hr>

			<h3>Text Formatting <small>- camel_case(), remove_camel_case(), snake_case(), alphanumeric(), prettify()</small></h3>

			<?php $string = 'Lorem ipsum, dolor sit amet.'; ?>
			
			<p>
				New Test String <code>"<?php echo $string; ?>"</code>
			</p>
			<p>
				Alphanumeric with spaces:
				<?php var_dump(alphanumeric($string)); ?>
			</p>
			<p>
				Alphanumeric without spaces:
				<?php var_dump(alphanumeric($string, true)); ?>
			</p>
			<p>
				camelCase with lower first character:
				<?php var_dump(camel_case($string)); ?>
			</p>
			<p>
				CamelCase with upper first character:
				<?php var_dump(camel_case($string, true)); ?>
			</p>
			<p>
				Remove CamelCase:
				<?php var_dump(remove_camel_case(camel_case($string))); ?>
			</p>
			<p>
				snake_case using  <code>"_"</code> as a seperator:
				<?php var_dump(snake_case($string)); ?>
			</p>
			<p>
				snake-case using  <code>"-"</code> as a seperator:
				<?php var_dump(snake_case($string, '-')); ?>
			</p>
			<p>
				remove snake-case:
				<?php var_dump(prettify(snake_case($string, '-'))); ?>
			</p>


		</section>

	</div>

</div>

<?php render_template('footer'); ?>