<?php
/**
 * PSR-4 autoloader
 *
 * @package Autoloader
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

require('src/class-harmony-psr0-autoloader.php');
require('src/class-harmony-psr4-autoloader.php');

/**
 * Add the autoloader to the registry
 * 
 * @return void
 */
function autoloader_config_setup() {
    add_registry_file(__DIR__ . '/config.php');
    load_registry_file(__DIR__ . '/config.php');
    get_registry('autoloader.psr-0')->register();
    get_registry('autoloader.psr-4')->register();
}
add_action('modules_loaded' , 'autoloader_config_setup', 10);