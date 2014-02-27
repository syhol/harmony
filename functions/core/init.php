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
define('THEME_DIR',     dirname(dirname(dirname(__FILE__))) . DS);
define('TEMPLATES_DIR', THEME_DIR       . 'templates'       . DS);
define('ASSETS_DIR',    THEME_DIR       . 'assets'          . DS);
define('FUNCTIONS_DIR', THEME_DIR       . 'functions'       . DS);
define('CORE_DIR',      FUNCTIONS_DIR   . 'core'            . DS);
define('MODULES_DIR',   FUNCTIONS_DIR   . 'modules'         . DS);
define('VENDOR_DIR',    FUNCTIONS_DIR   . 'vendor'          . DS);
define('CLASS_DIR',     FUNCTIONS_DIR   . 'psr-0'           . DS);

if (false === defined('ENV')) {
    define('ENV', 'live');
}

// Include composer autoloader
include(VENDOR_DIR . 'autoload.php');

// require php helpers
require(CORE_DIR . 'php-helpers.php');

// require wordpress helpers
require(CORE_DIR . 'wp-helpers.php');

// require wordpress hooks
require(CORE_DIR . 'wp-hooks.php');

// require data bindings for templates
require(CORE_DIR . 'data-bindings.php');

// Include modules
$dir = new DirectoryIterator(MODULES_DIR);
foreach ($dir as $module_dir) {
    if ( ! $module_dir->isDot() && $module_dir->isDir() ) {
        $module_init = $module_dir->getPathname() . DS . $module_dir->getFilename() . '.php';
    } elseif($module_dir->isFile()) {
        $module_init = $module_dir->getPathname();
    } else {
        continue;
    }
    include($module_init);
}

do_action('theme_modules_loaded');