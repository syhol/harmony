<?php
/**
 * Form Library for wordpress
 * 
 * @package Sorcery
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 0.1.0
 * @uses    Glyph, Divinity
 */


require('sorcery-common/sorcery-common.php');

require('sorcery-widgets/sorcery-widgets.php');
require('sorcery-layouts/sorcery-layouts.php');
require('sorcery-validation/sorcery-validation.php');

//require('sorcery-fields/sorcery-fields.php');
//require('sorcery-validation/sorcery-validation.php');
//require('sorcery-forms/sorcery-forms.php');

/**
 * Setup the sorcery widgets factory
 * 
 * @return void
 */
function sorcery_config_setup()
{
	add_registry_file(__DIR__ . '/config.php');
	load_registry_file(__DIR__ . '/config.php');
}
add_action('modules_loaded' , 'sorcery_config_setup', 10);

/**
 * Setup the sorcery widgets factory
 * 
 * @return void
 */
function sorcery_factory_setup()
{
	$sub_modules = array('widgets', 'layouts', 'validation'); 
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

/**
 * Register view directories
 *
 * @param $factory
 * @return void
 */
function sorcery_divinity_template_init($factory)
{
	$factory->add_directory(get_module_path('sorcery/sorcery-widgets/templates/'), 'sorcery-widgets');
	$factory->add_directory(get_module_path('sorcery/sorcery-layouts/templates/'), 'sorcery-layouts');
}
add_action('divinity_loaded', 'sorcery_divinity_template_init');