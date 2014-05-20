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
 */


require('helpers.php');

/**
 * Build a new template object
 * 
 * @param  string   $request 
 * @param  array	$data
 * @return void|string
 */
function template($request, array $data = array())
{
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
 * Prepare the data and path for a template
 * 
 * @param  string   $path 
 * @param  array	$data
 * @return array			Contains the [0] => $data and [1] => $path
 */
function parse_template_data($request, array $data = array())
{
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
 * To process the request into a path, the module prefix must be stripped.
 *
 * @param  string $path 
 * @return string
 */
function divinity_strip_prefix_from_template_path($path)
{
	if (str_contains($path, ':')) {
		$pos = strpos($path, ':');
		$path = substr($path, $pos + 1);
	}
	return $path;
}
add_filter('template_path', 'divinity_strip_prefix_from_template_path', 5, 1);

/**
 * Set the template engine based on the extension in the request-cache
 *
 * @param  Divinity_Engine $engine
 * @param  string          $directory
 * @param  string          $path
 * @param  string          $request
 * @return Divinity_Engine
 */
function divinity_set_template_engine($engine, $directory, $path, $request)
{
	if ($cache = get_registry('divinity.request-cache.' . $request . '.engine', false)) {
		return $cache;
	}

	if ($extension = get_registry('divinity.request-cache.' . $request . '.extension', false)) {
		$engines = get_registry('divinity.engine', array());
		foreach ($engines as $engine_test) {
			if ($extension === $engine_test->get_extension()) {
				$engine = $engine_test;
				set_registry('divinity.request-cache.' . $request . '.engine', $engine);
			}
		}
	}

	return $engine;
}
add_filter('template_engine', 'divinity_set_template_engine', 5, 4);

/**
 * If there is a "module:" prefix, change the template directory 
 *
 * If there is a "module:" prefix, change the template directory
 * to that modules template directory , e.g.
 * /{theme}/functions/modules/{module}/templates
 * 
 * @param  string $directory 
 * @param  string $path 
 * @param  string $request 
 * @return string
 */
function divinity_module_template_directory($directory, $path, $request)
{
	if (str_contains($request, ':')) {
		list($module, $new_path) = explode(':', $request);
		$directory = get_module_path($module . '/templates/');
	}
	return $directory;
}
add_filter('template_location', 'divinity_module_template_directory', 6, 4);

/**
 * Find the file and save its details to runtime cache against the request name
 * 
 * @param  string $directory 
 * @param  string $path 
 * @param  string $request 
 * @return string
 */
function divinity_template_request_cache($directory, $path, $request)
{	
	// See if there is a request cache in the registry, if so, use it
	if ($cache = get_registry('divinity.request-cache.' . $request . '.directory')) {
		return $cache;
	}

	// See if there is a request-cache in the DB
	$request_transient = get_transient('divinity.request-cache');
	
	$request_cache = isset($request_transient[$request]) ? $request_transient[$request] : false ;

	// Run glob to find files and get request data
	if ( ! $request_cache || ! file_exists($request_cache['raw'] )) {
		$results = array();
		$in_template = str_contains($directory, get_theme_path());
		if ($in_template && is_child_theme()) {
			$child_directory = str_replace(get_theme_path(), get_child_theme_path(), $directory);
			$results = array_merge($results, glob($child_directory . $path . '.*', GLOB_NOSORT));
		}

		$results = array_merge($results, glob($directory . $path . '.*', GLOB_NOSORT));
		
		$request_cache = array(
			'raw' => false,
			'directory' => $directory,
			'extension' => false
		);

		if ( ! empty($results) ) {
			$result = array_shift($results);
			list($directory, $extension) = explode($path, $result);
			$request_cache['raw'] = $result;
			$request_cache['extension'] = $extension;
		}

		// Set DB transient with an hour timeout
		$request_transient[$request] = $request_cache;
		set_transient('divinity.request-cache', $request_transient, 60 * 60);
	}

	set_registry('divinity.request-cache.' . $request, $request_cache);

	return $directory;
}
add_filter('template_location', 'divinity_template_request_cache', 50, 3);

/**
 * Add the divinity oop structure to the psr-0 class loader and register engines
 * 
 * @return void
 */
function divinity_init()
{
	get_registry('autoloader.psr-0')->addNamespace('Divinity', __DIR__ . '/src');
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

	// Make sure a cache directory is set up
	$upload_dir = wp_upload_dir();
	$cache = $upload_dir['basedir'] . '/cache';
	if( ! is_dir($cache) ) {
		mkdir($cache, 0755, true);
	}
	return $cache;
}
add_action('modules_loaded' , 'divinity_init', 90);
