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
 * @version 1.0.0
 */

require('helpers.php');

/**
 * Build a new template object
 * 
 * @param  string   $request 
 * @param  array	$data
 * @return void|string
 */
function template($request, array $data = array()) {
	list($directory, $path, $engine, $data) = parse_template_data($request, $data);
	return new Divinity_Template($directory, $path, $engine, $data);
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
function compile_template($request, array $data = array()) {
	return template($request, $data);
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
function render_template($request, array $data = array()) {
	return template($request, $data)->render();
}

/**
 * Prepare the data and path for a template
 * 
 * @param  string   $path 
 * @param  array	$data
 * @return array			Contains the [0] => $data and [1] => $path
 */
function parse_template_data($request, array $data = array()) {
	$directory = get_template_path();
	$path = $request;
	$engine = get_registry('divinity.engine.php');

	$filters = array(
		'template_data',
		'template_data_' . $request,
		'template_path',
		'template_path_' . $request,
		'template_location',
		'template_location_' . $request,
		'template_engine',
		'template_engine_' . $request,
	);

	$data = apply_filters($filters[0], $data, $request);
	$data = apply_filters($filters[1], $data, $request);
	$path = apply_filters($filters[2], $path, $request, $data);
	$path = apply_filters($filters[3], $path, $request, $data);
	$directory = apply_filters($filters[4], $directory, $path, $request, $data);
	$directory = apply_filters($filters[5], $directory, $path, $request, $data);
	$engine = apply_filters($filters[6], $engine, $directory, $path, $request, $data);
	$engine = apply_filters($filters[7], $engine, $directory, $path, $request, $data);
	$path .= $engine->get_extension();
	return array($directory, $path, $engine, $data);
}

/**
 * DOC ME
 */
function strip_prefix_from_template_path($path) {
	if (str_contains($path, ':')) {
		$pos = strpos($path, ':');
		$path = substr($path, $pos + 1);
	}
	return $path;
}
add_filter('template_path', 'strip_prefix_from_template_path', 5, 1);

/**
 * DOC ME
 */
function select_template_engine_if_file_exists($engine, $directory, $path) {
	$engines = get_registry('divinity.engine', array());
	foreach ($engines as $engine_test) {
		$ext = $engine_test->get_extension();
		if(file_exists($directory . $path . $ext)) {
			return $engine_test;
		}
	}
	return $engine;
}
add_filter('template_engine', 'select_template_engine_if_file_exists', 5, 3);

/**
 * DOC ME
 */
function set_module_template_directory($directory, $path, $request) {
	if (str_contains($request, ':')) {
		list($module, $new_path) = explode(':', $request);
		$directory = get_module_path($module . '/templates/');
	}
	return $directory;
}
add_filter('template_location', 'set_module_template_directory', 6, 3);

/**
 * Add the divinity oop structure to the psr-0 class loader
 * 
 * @return void
 */
function divinity_init() {
	get_registry('autoloader.psr-0')->addNamespace('Divinity', __DIR__ . '/src');
	//get_registry('autoloader.psr-0')->addNamespace('Mustache', __DIR__ . '/src');
	//get_registry('autoloader.psr-0')->addNamespace('Twig', __DIR__ . '/src');
	//get_registry('autoloader.psr-4')->addNamespace('Illuminate\\View\\', __DIR__ . '/src');
	set_registry('divinity.engine.php', new Divinity_Engine_PHP);
	if(class_exists('Mustache_Template')) {
		set_registry('divinity.engine.mustache', new Divinity_Engine_Mustache);
	}
	if(class_exists('Twig_Template')) {
		set_registry('divinity.engine.twig', new Divinity_Engine_Twig);
	}
	if(class_exists('Illuminate\View\Compilers\BladeCompiler')) {
		set_registry('divinity.engine.blade', new Divinity_Engine_Blade);
	}
}
add_action('modules_loaded' , 'divinity_init', 90);
