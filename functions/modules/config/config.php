<?php
/**
 * Config Module
 *
 * Lets theme config variables be get/set using a clean API without the need to 
 * work directly with global variables. also allows the use of per environment
 * config, providing a diffrent set of config for each environment.
 *
 * @package Config
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

$theme_config = array();

require('functions.php');

function load_initial_config() {
    set_config('config_file', get_function_path('custom/config.php'));
    load_environment_config('all');
    load_environment_config();
}
add_action('modules_loaded', 'load_initial_config');
