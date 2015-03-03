<?php
/**
 * Divinity Templates
 *
 * A template loader module that loads a template from dynamic locations
 * (usually the themes TEMPLATES_PATH) and sets up variables to be 
 * include in the templates scope. Using the render_template action the path 
 * and variables (data) can be changed/overridden. 
 *
 * @package Divinity
 * @uses	Location_Helpers
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.1.0
 * @uses    Glyph, Charms
 */


require('helpers.php');

/**
 * Build a new template object
 * 
 * @param  string   			$request 
 * @param  Traversable|array	$data
 * @return Divinity_Template
 */
function template($request, $data = array())
{
	return get_registry('divinity.factory')->create_template($request, $data);
}

/**
 * Compile a template then returns it as a string
 * 
 * Pass a path and a dataset to this function and template hooks will 
 * attempt to interpret the path into a real file path, then the file is 
 * included and the data array is extracted in to the templates scope.
 * The contence of the file is then returned
 * 
 * @param  string   $request 
 * @param  array	$data
 * @return void|string
 */
function compile_template($request, array $data = array())
{
	return template($request, $data)->compile();
}

/**
 * Render a template from the templates directory
 * 
 * Pass a path and a dataset to this function and template hooks will 
 * attempt to interpret the path into a real file path, then the file is 
 * included and the data array is extracted in to the templates scope.
 * The contence of the file is then outputted
 * 
 * @param  string   $request 
 * @param  array	$data
 * @return void|string
 */
function render_template($request, array $data = array())
{
	return template($request, $data)->render();
}

/**
 * Add the divinity oop structure to the psr-0 class loader and register engines
 * 
 * @return void
 */
function divinity_init()
{
	get_registry('autoloader.psr-0')->addNamespace('Divinity', __DIR__ . '/src');

	$engines = array();

	$engines[] = new Divinity_Engine_PHP;

	if (class_exists('Mustache_Template')) {
		$engines[] = new Divinity_Engine_Mustache;
	}
	if (class_exists('Twig_Template')) {
		$engines[] = new Divinity_Engine_Twig;
	}
	if (class_exists('Illuminate\View\Compilers\BladeCompiler')) {
		$engines[] = new Divinity_Engine_Blade;
	}

	$directories = array(get_template_path());

	$factory = new Divinity_TemplateFactory($directories, $engines);
	set_registry('divinity.factory', $factory);

	// Make sure a cache directory is set up
	$upload_dir = wp_upload_dir();
	$cache = $upload_dir['basedir'] . '/cache';
	if( ! is_dir($cache) ) {
		mkdir($cache, 0755, true);
	}

	do_action('divinity_loaded', $factory);

	return $cache;
}
add_action('harmony_loaded' , 'divinity_init', 90);
