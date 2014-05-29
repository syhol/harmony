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

// Directory constants
$theme = dirname(dirname(dirname(__FILE__)));
$directory_constants = array(
	'THEME_PATH'     => $theme . DS,
	'TEMPLATES_PATH' => $theme . DS . 'templates' . DS,
	'ASSETS_PATH'    => $theme . DS . 'assets' . DS,
	'FUNCTIONS_PATH' => $theme . DS . 'functions' . DS,
	'CORE_PATH'      => $theme . DS . 'functions' . DS . 'core' . DS,
	'MODULES_PATH'   => $theme . DS . 'functions' . DS . 'modules' . DS,
	'VENDOR_PATH'    => $theme . DS . 'functions' . DS . 'vendor' . DS,
	'CLASS_PATH'     => $theme . DS . 'functions' . DS . 'psr-0' . DS,
	'CUSTOM_PATH'    => $theme . DS . 'functions' . DS . 'custom' . DS,
);
foreach ($directory_constants as $name => $path) {
	if ( ! defined($name) ) {
		define($name, $path);
	}
}

// Environment constant fallback
if (false === defined('ENV')) {
	define('ENV', 'live');
}

// Load module loader
require(CORE_PATH . 'src/Harmony/Module.php');
require(CORE_PATH . 'src/Harmony/Module/Loader.php');
require(CORE_PATH . 'src/Harmony/Module/Factory.php');

// Run the module loader to load all modules
$module_loader = new Harmony_Module_Loader(MODULES_PATH, new Harmony_Module_Factory);
$module_loader->run();
do_action('modules_loaded');

// Load the composer autoloader
if (file_exists(VENDOR_PATH . 'autoload.php')) {
	require(VENDOR_PATH . 'autoload.php');
	do_action('composer_loaded');
}

// Harmony core loaded 
do_action('harmony_loaded');
define('HARMONY_LOADED', true);

// Load custom site functionality
if (file_exists(CUSTOM_PATH . 'init.php')) {
	require(CUSTOM_PATH . 'init.php');
	do_action('custom_loaded');
}