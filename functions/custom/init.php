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


// add the config file and load it
add_registry_file(CUSTOM_PATH . 'config.php');
initialize_registry();

// require php helpers
require(CUSTOM_PATH . 'php-helpers.php');

// require wordpress helpers
require(CUSTOM_PATH . 'wp-helpers.php');

// require wordpress hooks
require(CUSTOM_PATH . 'wp-hooks.php');

// require data bindings for templates
require(CUSTOM_PATH . 'data-bindings.php');
