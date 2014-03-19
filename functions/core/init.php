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

// Include composer autoloader
include(VENDOR_PATH . 'autoload.php');

// Require php helpers
require(CORE_PATH . 'php-helpers.php');

// Require wordpress helpers
require(CORE_PATH . 'wp-helpers.php');

// Require wordpress hooks
require(CORE_PATH . 'wp-hooks.php');

// Include modules
$dir = new DirectoryIterator(MODULES_PATH);
foreach ($dir as $module_path) {
    if ( ! $module_path->isDot() && $module_path->isDir() ) {
        $module_init = $module_path->getPathname() . DS . $module_path->getFilename() . '.php';
    } elseif($module_path->isFile()) {
        $module_init = $module_path->getPathname();
    } else {
        continue;
    }
    include($module_init);
}

do_action('modules_loaded');

// require data bindings for templates
require(CUSTOM_PATH . 'init.php');