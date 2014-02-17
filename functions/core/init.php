<?php
/**
 * Theme Core
 * 
 * Initialise application logic
 *
 * @package Theme Core
 * @author Simon Holloway
 * @version 1.0.0
 */

// Define constants
define('L', PHP_EOL);
define('DS', DIRECTORY_SEPARATOR);
define('FUNC_DIR', dirname(__DIR__) . DS);
define('CORE_DIR', FUNC_DIR . 'core' . DS);
define('MODULES_DIR', FUNC_DIR . 'modules' . DS);
define('VENDOR_DIR', FUNC_DIR . 'vendor' . DS);
define('CLASS_DIR', FUNC_DIR . 'psr-0' . DS);

if (false === defined('ENV')) {
    define('ENV', 'live');
}

// Include composer autoloader
include(VENDOR_DIR . 'autoload.php');

// Include php helpers
include(CORE_DIR . 'php-helpers.php');

// Include wordpress helpers
include(CORE_DIR . 'wp-helpers.php');

// Include wordpress hooks
include(CORE_DIR . 'wp-hooks.php');

// Include modules
$dir = new DirectoryIterator(MODULES_DIR);
foreach ($dir as $module_dir) {
    if ( ! $module_dir->isDot() && $module_dir->isDir() ) {
        $module_init = $module_dir->getPathname() . DS . 'init.php';
        if (is_readable($module_init)) {
            include $module_init;
        }
    }
}

do_action('theme_modules_loaded');