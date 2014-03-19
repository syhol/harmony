<?php
/**
 * Functions for the config module
 *
 * @package Config
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

/**
 * Set a config variable
 *
 * You can use array dot notation
 * 
 * @see array_dot_set()
 * @param   string  $key
 * @param   mixed   $value 
 * @return  void
 */
function set_config($key, $value)
{
    global $theme_config;
    array_dot_set($theme_config, $key, $value);
}

/**
 * Get a config variable
 * 
 * You can use array dot notation
 * 
 * @see array_dot_get()
 * @param   string  $key
 * @param   misex   $default default value to return if none found
 * @return  mixed
 */
function get_config($key, $default = null)
{
    global $theme_config;
    return array_dot_get($theme_config, $key, $default);
}

/**
 * Empty the config variable
 * 
 * @return void
 */
function reset_config()
{
    global $theme_config;
    $theme_config = array();
}

/**
 * Load an array into the config variable via set_config()
 *
 * Does not delete old values unless they are overridden
 * 
 * @see set_config()
 * @param array $config
 * @return void
 */
function load_config(array $config)
{
    foreach ($config as $key => $value) {
        set_config($key, $value);
    }
}

/**
 * Load an array from the config.php into the config variable
 * 
 * @see load_config()
 * @param  string $config_env defaults to whats in the ENV constant
 * @return void
 */
function load_environment_config($config_env = null)
{
    if ( is_null($config_env) ) {
        $config_env = ENV;
    }

    $all_config = require(get_config('config_file'));

    if ( ! isset($all_config[$config_env]) ) {
        return;
    }

    load_config($all_config[$config_env]);
}