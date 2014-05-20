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

// General constants
define('L', PHP_EOL);
define('DS', DIRECTORY_SEPARATOR);

// Directory constants
define('THEME_PATH',     dirname(dirname(dirname(__FILE__)))  . DS);
define('TEMPLATES_PATH', THEME_PATH       . 'templates'       . DS);
define('ASSETS_PATH',    THEME_PATH       . 'assets'          . DS);
define('FUNCTIONS_PATH', THEME_PATH       . 'functions'       . DS);
define('CORE_PATH',      FUNCTIONS_PATH   . 'core'            . DS);
define('MODULES_PATH',   FUNCTIONS_PATH   . 'modules'         . DS);
define('VENDOR_PATH',    FUNCTIONS_PATH   . 'vendor'          . DS);
define('CLASS_PATH',     FUNCTIONS_PATH   . 'psr-0'           . DS);
define('CUSTOM_PATH',    FUNCTIONS_PATH   . 'custom'          . DS);

if (false === defined('ENV')) {
	define('ENV', 'live');
}

// Require php helpers
require(CORE_PATH . 'php-helpers.php');

// Require wordpress helpers
require(CORE_PATH . 'wp-helpers.php');

// Require wordpress hooks
require(CORE_PATH . 'wp-hooks.php');

// Load module classes
require(CORE_PATH . 'class-loader.php');

// Include modules
$module_loader = new Harmony_Module_Loader(MODULES_PATH, new Harmony_Module_Factory);
$module_loader->run();

// Include composer autoloader
if (file_exists(VENDOR_PATH . 'autoload.php')) {
	require(VENDOR_PATH . 'autoload.php');
}

do_action('modules_loaded');

// require data bindings for templates
require(CUSTOM_PATH . 'init.php');

