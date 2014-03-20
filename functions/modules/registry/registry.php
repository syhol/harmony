<?php
/**
 * Registry Module
 *
 * Lets application variables be get/set using a clean API without the need to 
 * work directly with global variables. also allows the use of per environment
 * variables, providing a diffrent set of variables for each environment.
 *
 * @package Registry
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

require('registry-meta.php');
require('functions.php');

/**
 * Load registry vars from registry files for the 'all' and current environment
 * 
 * @return void
 */
function initialize_registry() {
    load_environment_registry('all');
    load_environment_registry();
}
add_action('modules_loaded', 'initialize_registry', 50);
