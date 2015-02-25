<?php
/**
 * Theme Core
 * 
 * Initialise application logic
 *
 * @package  Theme_Core
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  1.0.0
 */

// Don't load harmony twice
if (defined('HARMONY_LOADED')) {
	return;
}

// General constants
define('L', PHP_EOL);
define('DS', DIRECTORY_SEPARATOR);

// Environment constant fallback
if (false === defined('ENV')) {
	define('ENV', 'live');
}

//Set the harmony array defaults
$theme = dirname(dirname(dirname(__FILE__)));
$default_harmony_config = array(
	'env' => ENV,
	'path' => array(
		'theme'     => $theme . DS,
		'templates' => $theme . DS . 'templates' . DS,
		'assets'    => $theme . DS . 'assets' . DS,
		'functions' => $theme . DS . 'functions' . DS,
		'core'      => $theme . DS . 'functions' . DS . 'core' . DS,
		'vendor'    => $theme . DS . 'functions' . DS . 'vendor' . DS,
		'class'     => $theme . DS . 'functions' . DS . 'psr-0' . DS,
		'modules'   => array($theme . DS . 'functions' . DS . 'modules' . DS),
		'custom'    => array($theme . DS . 'functions' . DS . 'custom' . DS),
	),
	'use-default-modules' => true,
	'use-default-custom' => true,
);

if ( ! isset($harmony_config) || ! is_array($harmony_config) )
	$harmony_config = array();

// Set up the harmony array
$harmony = array_merge_recursive($default_harmony_config, $harmony_config);

// Remove defaults if set to false
if ( ! $harmony['use-default-modules'] ) {
	$default_module_dir = $default_harmony_config['path']['modules'][0];
	$key = array_search($default_module_dir, $harmony['path']['modules']);
	if ($key !== false) {
		unset($harmony['path']['modules'][$key]);
	}
}
if ( ! $harmony['use-default-custom'] ) {
	$default_module_dir = $default_harmony_config['path']['custom'][0];
	$key = array_search($default_module_dir, $harmony['path']['custom']);
	if ($key !== false) {
		unset($harmony['path']['custom'][$key]);
	}
}

// Set constants from the paths
foreach ($harmony['path'] as $name => $path) {
	if ( is_string($path) && ! defined($name) ) {
		define(strtoupper($name) . '_PATH', $path);
	}
}

// Load module loader
require($harmony['path']['core'] . 'src/Harmony/Module.php');
require($harmony['path']['core'] . 'src/Harmony/Module/Loader.php');
require($harmony['path']['core'] . 'src/Harmony/Module/Factory.php');

// Run the module loader to load all modules
$module_loader = new Harmony_Module_Loader(
	$harmony['path']['modules'], 
	new Harmony_Module_Factory
);
$module_loader->run();
do_action('modules_loaded');

// Load the composer autoloader
if (file_exists($harmony['path']['vendor'] . 'autoload.php')) {
	require($harmony['path']['vendor'] . 'autoload.php');
}
do_action('composer_loaded');

// Harmony core loaded 
define('HARMONY_LOADED', true);
do_action('harmony_loaded');

// Load custom site functionality
foreach ($harmony['path']['custom'] as $custom) {
	if (file_exists($custom . 'init.php')) {
		require($custom . 'init.php');
	}
}
do_action('custom_loaded');
