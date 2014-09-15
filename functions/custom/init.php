<?php
/**
 * Theme Custom
 * 
 * Initialise custom application logic
 *
 * @package  Theme_Custom
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  1.0.0
 */


// add and load the config file to the registry
add_registry_file(__DIR__ . '/config.php');
load_registry_file(__DIR__ . '/config.php');

// require php helpers
require(__DIR__ . '/php-helpers.php');

// require wordpress helpers
require(__DIR__ . '/wp-helpers.php');

// require wordpress hooks
require(__DIR__ . '/wp-hooks.php');

// require data bindings for templates
require(__DIR__ . '/data-bindings.php');
