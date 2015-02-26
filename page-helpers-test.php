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

			<h3>Sorcery Forms</h3>

			<?php $widgets = get_registry('sorcery.widgets.factory'); ?>
			<?php $layouts = get_registry('sorcery.layouts.factory'); ?>
			
			<h4>Widgets</h4>

			<label>Textbox</label>

			<?php echo sorcery_widget_text(array('id' => 'My Textbox', 'value' => 'The Value')); ?>
			
			<label>Textarea</label>

			<?php echo sorcery_widget_textarea(array('id' => 'My Textarea', 'value' => 'The Value')); ?>

			<label>Radio Button</label>

			<?php echo sorcery_widget_radio(array('id' => 'My Radio', 'value' => 'one')); ?>
			<?php echo sorcery_widget_radio(array('id' => 'My Radio', 'value' => 'two', 'checked' => true)); ?>
			<?php echo sorcery_widget_radio(array('id' => 'My Radio', 'value' => 'three')); ?>

			<label>Checkbox</label>

			<?php echo sorcery_widget_checkbox(array('id' => 'My Checkbox', 'value' => 'one')); ?>
			<?php echo sorcery_widget_checkbox(array('id' => 'My Checkbox', 'value' => 'two', 'checked' => true)); ?>
			<?php echo sorcery_widget_checkbox(array('id' => 'My Checkbox', 'value' => 'three', 'checked' => true)); ?>

			<label>Select</label>

			<?php 
				echo sorcery_widget_select(array(
					'id' => 'My Select', 'value' => 'three', 'options' => array(
						'one' => 'One',
						'two' => 'Two',
						'three' => 'Three',
						'Four' => array(
							'five' => 'Five',
							'six' => 'Six',
							'seven' => 'Seven'
						)
					)
				));
			?>

			<label>Other ways of getting the widget</label>

			<?php echo sorcery_widget_text(array('id' => 'My Textbox', 'value' => 'The Value')); ?>
			<?php echo $widgets['text']->bulk_set(array(
				'attributes' => array(
					'name' => 'My Textbox', 
					'value' => 'The Value',
				)
			)); ?>
			<?php echo $widgets->get('text', array('id' => 'My Textbox', 'value' => 'The Value')); ?>
			<?php echo $widgets->text(array('id' => 'My Textbox', 'value' => 'The Value')); ?>

			<h4>Layouts</h4>

			<?php $widget = $widgets->text(array('id' => 'My Textbox', 'value' => 'The Value')); ?>

			<?php echo sorcery_layout_general(array('widget' => $widget, 'label' => 'My Field')); ?>

			<?php echo sorcery_layout_general(array(
				'widget' => $widget, 
				'label' => 'My Field', 
				'help' => 'Im a little help section'
			)); ?>

			<?php echo sorcery_layout_general(array(
				'widget' => $widget, 
				'label' => 'My Field', 
				'help' => 'Im a little help section',
				'errors' => array('This field is required', 'Must be an email address')
			)); ?>

			<?php echo sorcery_layout_horizontal(array(
				'widget' => $widget, 
				'label' => 'My Field', 
			)); ?>

			<?php echo sorcery_layout_horizontal(array(
				'widget' => $widget, 
				'label' => 'My Field', 
				'errors' => array('This field is required')
			)); ?>

			<?php $widget['attributes.value'] = ''; ?>
			<?php $widget['attributes.placeholder'] = 'My Placeholder'; ?>
			<?php echo $layouts->horizontal(array('widget' => $widget)); ?>

			<h4>Validation</h4>

			<p>
				Required 
				<?php var_dump(sorcery_validate_required('test')); ?>
				<?php var_dump(sorcery_validate_required('')); ?>
			</p>

			<p>
				Pattern 
				<?php var_dump(sorcery_validate_pattern('test', '/[A-Za-z0-9]/')); ?>
				<?php var_dump(sorcery_validate_pattern('t£$t', '/[A-Za-z0-9]/')); ?>
			</p>

			<p>
				Max Char 
				<?php var_dump(sorcery_validate_maxchar('test', 5)); ?>
				<?php var_dump(sorcery_validate_maxchar('testextra', 5)); ?>
			</p>
			

			<hr>

			<h3>Voodoo Models</h3>

			<h4>Voodoo Posts - Like WP_Post but more badass</h4>

			<?php 

			$voodoo_post = post(1); 
			$voodoo_post->post_title = 'Hello World';
			$voodoo_post->post_content = 'Welcome to WordPress. This is your first post. 
			Edit or delete it, then start blogging! Welcome to WordPress. This is your 
			first post. Edit or delete it, then start blogging! Welcome to WordPress. 
			This is your first post. Edit or delete it, then start blogging! Welcome to 
			WordPress. This is your first post. Edit or delete it, then start blogging! 
			Welcome to WordPress. This is your first post. Edit or delete it, then start 
			blogging! Welcome to WordPress. This is your first post. Edit or delete it, 
			then start blogging! Welcome to WordPress. This is your first post. Edit or 
			delete it, then start blogging! Welcome to WordPress. This is your first post. 
			Edit or delete it, then start blogging! Welcome to WordPress. This is your 
			first post. Edit or delete it, then start blogging! Welcome to WordPress. 
			This is your first post. Edit or delete it, then start blogging! Welcome to 
			WordPress. This is your first post. Edit or delete it, then start blogging! 
			Welcome to WordPress. This is your first post. Edit or delete it, then start 
			blogging! Welcome to WordPress. This is your first post. Edit or delete it, 
			then start blogging! Welcome to WordPress. This is your first post. Edit or 
			delete it, then start blogging! Welcome to WordPress. This is your first post. 
			Edit or delete it, then start blogging! Welcome to WordPress. This is your 
			first post. Edit or delete it, then start blogging!';


			$voodoo_post['feature'] = array(
				'items' => array('One', 'Two', 'Three'),
				'title' => 'Feature title',
				'subtitle' => '...and subtitle'
			);

			$voodoo_original = clone $voodoo_post;

			?>

			<p>
				Check out all its vars
				<?php var_dump($voodoo_post); ?>
			</p>

			<p>
				I can get post data and post meta data 
				<?php //Check out the template at {theme}/templates/example/voodoo.php ?>
				<?php render_template('examples/voodoo', array('voodoo_post' => $voodoo_post)); ?>
			</p>

			<p>
				I can set post data and post meta data too
				<?php 
				$voodoo_post->shift('feature.items');
				$voodoo_post->unshift('feature.items', 'Alpha');
				$voodoo_post->pop('feature.items');
				$voodoo_post->push('feature.items', 'Charlie');
				$voodoo_post->post_title = 'New World';
				$voodoo_post['post_content'] = 'New Content';
				$voodoo_post['feature.subtitle'] .= ' with a little extra';
				$voodoo_post->set('feature.content', 'Setting data on the fly...');

				//Check out the template at {theme}/templates/example/voodoo.php
				render_template('examples/voodoo', array('voodoo_post' => $voodoo_post));
				?>
			</p>

			<p>
				Although this won't save the data
				<?php //Check out the template at {theme}/templates/example/voodoo.php ?>
				<?php render_template('examples/voodoo', array('voodoo_post' => post(1))); ?>
			</p>

			<p>
				Calling <code>$voodoo->save()</code> will make edited data permanent 
				<?php 
				$voodoo_post->save();

				//Check out the template at {theme}/templates/example/voodoo.php
				render_template('examples/voodoo', array('voodoo_post' => post(1))); 

				// Return to old values
				$voodoo_post->post_title = $voodoo_original['post_title'];
				$voodoo_post->post_content = $voodoo_original['post_content'];
				$voodoo_post['feature'] = array(
					'items' => array('One', 'Two', 'Three'),
					'title' => 'Feature title',
					'subtitle' => '...and subtitle'
				);
				$voodoo_post->save(); 

				unset($voodoo_post->feature);
				unset($voodoo_post->post_title);
				$voodoo_post->save();
				$voodoo_post = post(1);
				var_dump($voodoo_post->get('feature'));
				var_dump($voodoo_post->get('post_title'));
				$voodoo_post['post_title'] = 'Hello World';
				$voodoo_post['feature'] = array(
					'items' => array('One', 'Two', 'Three'),
					'title' => 'Feature title',
					'subtitle' => '...and subtitle'
				);
				$voodoo_post->save(); 
				?>
			</p>

			<h4>Voodoo Term - Like wordpress terms, but totes more awesome!</h4>

			<?php $voodoo_terms = term(get_terms('category')); ?>

			Typical Voodoo Term:

			<?php var_dump($voodoo_terms[0]); ?>

			<h4>Voodoo User - Like WP_Users, With tons of amazballs</h4>

			<?php $voodoo_user = user(2); ?>

			Typical Voodoo User:

			<?php var_dump($voodoo_user); ?>

			<h4>Voodoo Setting - Using the wp_options table to the MAX!</h4>

			<?php $voodoo_setting = setting(); ?>

			Use a Voodoo Setting to retrive options from the database in a glyph way:

			<?php var_dump('$voodoo_setting->get("siteurl") returns: "' . $voodoo_setting->get('siteurl') . '"'); ?>

			Also get settings in a context:

			<?php $dashboard_widget_options = setting('dashboard_widget_options'); ?>

			<?php var_dump($dashboard_widget_options['dashboard_primary.title']); ?>

			<hr>

			<h3>Profiler</h3>
			
			<?php

			$using_twig = class_exists('Twig_Template');
			$using_mustache = class_exists('Mustache_Template');
			$using_blade = class_exists('Illuminate\View\Compilers\BladeCompiler');

			ob_start();

			$profile_strength = 10;

			profile_start('total'); 

			$diffs1 = array();
			for ($i = 1; $i <= $profile_strength; $i++) {
				profile_start(); 
				render_template('single-item', array('content' => 'look at me!'));
				$profile = profile_stop();
				$diffs1[] = $profile['time-diff'];
			}

			$diffs2 = array();
			for ($i = 1; $i <= $profile_strength; $i++) {
				profile_start(); 
				$template = new Divinity_Template(
					get_template_path(), 
					'single-item.php', 
					new Divinity_Engine_PHP,
					array('content' => 'look at me!', 'title' => 'Helpers Test', 'classes' => 'a')
				);
				$template->render();
				$profile = profile_stop();
				$diffs2[] = $profile['time-diff'];
			}
			
			$diffs3 = array();
			for ($i = 1; $i <= $profile_strength; $i++) {
				profile_start(); 
				$single_item = compile_template('single-item', array('content' => 'look at me!'), true);
				echo $single_item;
				$profile = profile_stop();
				$diffs3[] = $profile['time-diff'];
			}

			if($using_twig) {
				$diffs4 = array();
				for ($i = 1; $i <= $profile_strength; $i++) {
					profile_start(); 
					render_template('examples/twig-main', array(
						'title' => 'a', 
						'content' => 'b', 
						'partial' => array(
							'title' => 'c'
						)
					));
					$profile = profile_stop();
					$diffs4[] = $profile['time-diff'];
				}
			}
			
			if($using_mustache) {
				$diffs5 = array();
				for ($i = 1; $i <= $profile_strength; $i++) {
					profile_start(); 
					render_template('examples/mustache-template', array(
						'title' => 'a', 
						'content' => 'b', 
						'partial' => array(
							'title' => 'c'
						)
					));
					$profile = profile_stop();
					$diffs5[] = $profile['time-diff'];
				}
			}

			if($using_blade) {
				$diffs6 = array();
				for ($i = 1; $i <= $profile_strength; $i++) {
					profile_start(); 
					render_template('examples/blade-main', array(
						'title' => 'a', 
						'content' => 'b', 
						'partial' => array(
							'title' => 'c'
						)
					));
					$profile = profile_stop();
					$diffs6[] = $profile['time-diff'];
				}
			}
			
			ob_end_clean();

			$total = profile_stop('total');

			?>

			<table class="table table-striped">
				<thead>
					<tr><th>Type</th><th>Average Time Taken</th><th>Strength</th></tr>
				</thead>
				<tbody>
					<tr>
						<td>Standard render_template()</td>
						<td><?php echo array_sum($diffs1) / count($diffs1); ?></td>
						<td><?php echo $profile_strength; ?></td>
					</tr>
					<tr>
						<td>Manually creating Divinity_Template</td>
						<td><?php echo array_sum($diffs2) / count($diffs2); ?></td>
						<td><?php echo $profile_strength; ?></td>
					</tr>
					<tr>
						<td>Stardard compile_template()</td>
						<td><?php echo array_sum($diffs3) / count($diffs3); ?></td>
						<td><?php echo $profile_strength; ?></td>
					</tr>
					<?php if($using_twig): ?>
					<tr>
						<td>Twig render_template()</td>
						<td><?php echo array_sum($diffs4) / count($diffs4); ?></td>
						<td><?php echo $profile_strength; ?></td>
					</tr>
					<?php endif; ?>
					<?php if($using_mustache): ?>
					<tr>
						<td>Mustache render_template()</td>
						<td><?php echo array_sum($diffs5) / count($diffs5); ?></td>
						<td><?php echo $profile_strength; ?></td>
					</tr>
					<?php endif; ?>
					<?php if($using_blade): ?>
					<tr>
						<td>Blade render_template()</td>
						<td><?php echo array_sum($diffs6) / count($diffs6); ?></td>
						<td><?php echo $profile_strength; ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td>Total</td>
						<td><?php echo $total['time-diff']; ?></td>
						<td><?php echo $profile_strength * 5; ?></td>
					</tr>
				</tbody>
			</table>

			<hr>

			<h3>Divinity Templates</h3>
			
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
			<?php if($using_mustache): ?>

			<p>
				Oh whats that? you don't think PHP is a real templateing language?</br>
				How about mustache?
			</p>
			
			<div class="well">
				<?php render_template('examples/mustache-template', array(
					'title' =>'I am built with mustache!',
					'content' => 'How do ya like them apples?', 
					'partial' => array(
						'title' => 'Oh and i work with partials too'
					)
				)); ?>
			</div>
			<?php endif; ?>
			<?php if($using_twig): ?>

			<p>
				What now? you think mustache is a girly logicless template language?</br>
				How about twig?
			</p>
			
			<div class="well">
				<?php render_template('examples/twig-main', array(
					'title' =>'I am built with twig!',
					'content' => 'I\'m extending a layout template', 
					'partial' => array(
						'title' => 'Oh and i work with partials too'
					)
				)); ?>
			</div>
			<?php endif; ?>
			<?php if($using_blade): ?>

			<p>
				...And Blade
			</p>
			
			<div class="well">
				<?php render_template('examples/blade-main', array(
					'title' =>'I am built with blade!',
					'content' => 'Ouch that\'s razor sharp goodness', 
					'partial' => array(
						'title' => 'Also extending layouts and using partials'
					)
				)); ?>
			</div>
			<?php endif; ?>

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

			<table class="table table-striped">
				<thead>
					<tr><th>Request</th><th>Result</th></tr>
				</thead>
				<tbody>
					<tr>
						<td>get_route('to/my/route');</td>
						<td><?php echo get_route('to/my/route'); ?></td>
					</tr>
					<tr>
						<td>get_theme_url('to/my/resource.js');</td>
						<td><?php echo get_theme_url('to/my/resource.js'); ?></td>
					</tr>
					<tr>
						<td>get_site_url('to/my/resource.js');</td>
						<td><?php echo get_site_url('to/my/resource.js'); ?></td>
					</tr>
					<tr>
						<td>get_asset_url('js/resource.js');</td>
						<td><?php echo get_asset_url('js/resource.js'); ?></td>
					</tr>
					<tr>
						<td>get_template_url('single/template.php');</td>
						<td><?php echo get_template_url('single/template.php'); ?></td>
					</tr>
					<tr>
						<td>get_module_url('my-module/resource.js');</td>
						<td><?php echo get_module_url('my-module/resource.js'); ?></td>
					</tr>
					<tr>
						<td>get_theme_path('to/my/resource.php');</td>
						<td><?php echo get_theme_path('to/my/resource.php'); ?></td>
					</tr>
					<tr>
						<td>get_asset_path('php/resource.php');</td>
						<td><?php echo get_asset_path('php/resource.php'); ?></td>
					</tr>
					<tr>
						<td>get_template_path('single/template.php');</td>
						<td><?php echo get_template_path('single/template.php'); ?></td>
					</tr>
					<tr>
						<td>get_function_path('custom/funcs.php');</td>
						<td><?php echo get_function_path('custom/funcs.php'); ?></td>
					</tr>
					<tr>
						<td>get_module_path('my-module/resource.php');</td>
						<td><?php echo get_module_path('my-module/resource.php'); ?></td>
					</tr>
				</tbody>
			</table>

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