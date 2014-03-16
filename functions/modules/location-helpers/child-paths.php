<?php
/**
 * Child Path helpers for the Location Helpers module
 * 
 * @package  Location_Helpers
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */

/**
 * Get the theme absolute path and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string          absolute path to theme with extra path appended
 */
function get_child_theme_path($path = '') {
    return get_stylesheet_directory() . '/' . ltrim($path, '/\\');
}

/**
 * Get the theme asset absolute path and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string          url to assets with extra path appended
 */
function get_child_asset_path($path = '') {
    return get_child_theme_path('assets/' . ltrim($path, '/'));
}

/**
 * Get the theme template absolute path and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string          url to template with extra path appended
 */
function get_child_template_path($path = '') {
    return get_child_theme_path('templates/' . ltrim($path, '/'));
}

/**
 * Get the theme function absolute path and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string          url to function with extra path appended
 */
function get_child_function_path($path = '') {
    return get_child_theme_path('functions/' . ltrim($path, '/'));
}

/**
 * Get the theme module absolute path and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string          url to module with extra path appended
 */
function get_child_module_path($path = '') {
    return get_child_function_path('modules/' . ltrim($path, '/'));
}
