<?php
/**
 * Form Library for wordpress
 * 
 * @package Sorcery
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 0.1.0
 */

require('sorcery-widgets/sorcery-widgets.php');
require('sorcery-common/sorcery-common.php');
require('sorcery-layouts/sorcery-layouts.php');

//require('sorcery-fields/sorcery-fields.php');
//require('sorcery-validation/sorcery-validation.php');
//require('sorcery-forms/sorcery-forms.php');


/**
 * Redirect the sorcery-widgets templates to sorcery/sorcery-widgets/templates
 * 
 * @param string $path
 * @param string $original_path path passed into render_template
 * @param string $data
 * @return void
 */
function sorcery_template_redirect($path, $original_path, $data) {
	$sub_modules = array(
		'widgets',
		'layouts'
	); 

	foreach ($sub_modules as $sub_module) {
		if (str_contains($original_path, 'sorcery-' . $sub_module . ':')) {
				list($module, $new_path) = explode(':', $original_path);
				$module_template = get_module_path('/sorcery/sorcery-' . $sub_module . '/templates/' . $new_path . '.php');
				if (is_file($module_template)) {
					$path = $module_template;
				}
		}
	}

	return $path;
}
add_filter('template_path' , 'sorcery_template_redirect', 30, 3);

/**
 * Setup the sorcery widgets factory
 * 
 * @return void
 */
function sorcery_config_setup() {
	add_registry_file(__DIR__ . '/config.php');
	load_registry_file(__DIR__ . '/config.php');
}
add_action('modules_loaded' , 'sorcery_config_setup', 10);

/**
 * Setup the sorcery widgets factory
 * 
 * @return void
 */
function sorcery_factory_setup() {
	$sub_modules = array(
		'widgets',
		'layouts'
	); 

	foreach ($sub_modules as $sub_module) {
		$bindings = get_registry('sorcery.' . $sub_module . '.factory-bindings', array());
		$factory = new Sorcery_Factory();
		foreach ((array)$bindings as $id => $callback) {
			$factory->set($id, $callback);
		}
		set_registry('sorcery.' . $sub_module . '.factory', $factory);
	}

	
}
add_action('modules_loaded' , 'sorcery_factory_setup', 60);