<?php
/**
 * Template Module
 *
 * A small template loader module that loads a template from a prefedined 
 * location (usually the themes TEMPLATES_PATH) and sets up variables to be 
 * include in the templates scope. Using the render_template action the path 
 * and variables (data) can be changed/overridden. 
 *
 * @package Template
 * @uses	Location_Helpers
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

require('wrapper.php');
require('helpers.php');

/**
 * Build a new template object
 * 
 * @param  string   $path 
 * @param  array	$data
 * @return void|string
 */
function template($path, array $data = array()) {
	return new Template($path, $data);
}

/**
 * Compile a template then returns it as a string
 * 
 * Pass a path and a dataset to this function and template hooks will 
 * attempt to interpret the path into a real file path, then the file is 
 * included and the data array is extracted in to the templates scope.
 * The contence of the file is then returned
 * 
 * @param  string   $path 
 * @param  array	$data
 * @return void|string
 */
function compile_template($path, array $data = array()) {
	ob_start();
	render_template($path, $data);
	return ob_get_clean();
}

/**
 * Render a template from the templates directory
 * 
 * Pass a path and a dataset to this function and template hooks will 
 * attempt to interpret the path into a real file path, then the file is 
 * included and the data array is extracted in to the templates scope.
 * The contence of the file is then outputted
 * 
 * @param  string   $path 
 * @param  array	$data
 * @return void|string
 */
function render_template($path, array $data = array()) {
	list($path, $data) = parse_template_data($path, $data);
	if (is_array($data)) extract($data);
	require($path);
}

/**
 * Prepare the data and path for a template
 * 
 * @param  string   $path 
 * @param  array	$data
 * @return array			Contains the [0] => $data and [1] => $path
 */
function parse_template_data($path, array $data = array()) {
	$original_path = $path;
	$original_data = $data;
	$filters = array(
		'template_data',
		'template_data_' . $original_path,
		'template_path',
		'template_path_' . $original_path
	);
	$data = apply_filters($filters[0], $data, $original_data, $path);
	$data = apply_filters($filters[1], $data, $original_data, $path);
	$path = apply_filters($filters[2], $path, $original_path, $data);
	$path = apply_filters($filters[3], $path, $original_path, $data);
	return array($path, $data);
}

/**
 * Set the default path in the theme templates directory
 * 
 * Set the path to {TEMPLATES_PATH}/{$path}.php by default
 *  
 * @param string $path
 * @param string $original_path path passed into render_template
 * @param string $data
 * @return void
 */
function set_default_template_path($path, $original_path, $data) {
	$child_template = get_child_template_path($original_path . '.php');
	$parent_template = get_template_path($original_path . '.php');
	if (is_file($child_template)) {
		$path = $child_template;
	} elseif (is_file($parent_template)) {
		$path = $parent_template;
	}
	return $path;
}
add_filter('template_path', 'set_default_template_path', 5, 3);

/**
 * Set the path to module templates when the ":" operator is used
 * 
 * if a module template is called the path will be set to 
 * {MODULES_PATH}/{$module}/templates/{$path}.php  
 * 
 * @example render_template('mymodule:mydirectory/mytemplate');
 * 
 * @param string $path
 * @param string $original_path path passed into render_template
 * @param string $data
 * @return void
 */
function set_module_template_path($path, $original_path, $data) {
	if (str_contains($original_path, ':')) {
		list($module, $new_path) = explode(':', $original_path);
		$module_template = get_module_path($module . '/templates/' . $new_path . '.php');
		if (is_file($module_template)) {
			$path = $module_template;
		}
	}
	return $path;
}
add_filter('template_path', 'set_module_template_path', 6, 3);