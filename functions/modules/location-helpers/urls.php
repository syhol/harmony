<?php
/**
 * Url helpers for the Location Helpers module
 * 
 * @package  Location_Helpers
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */


/**
 * Get the site url path and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string		  url to site root with extra path appended
 */
function get_route($path = '')
{
	return get_bloginfo('url') . '/' . ltrim($path, '/');
}


/**
 * Get the theme url and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string		  url to theme with extra path appended
 */
function get_theme_url($path = '')
{
	return get_template_directory_uri() . '/' . ltrim($path, '/');
}

/**
 * Get the theme asset url and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string		  url to assets with extra path appended
 */
function get_asset_url($path = '')
{
	return get_theme_url('assets/' . ltrim($path, '/'));
}

/**
 * Get the theme template url and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string		  url to template with extra path appended
 */
function get_template_url($path = '')
{
	return get_theme_url('templates/' . ltrim($path, '/'));
}

/**
 * Get the theme function url and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string		  url to function with extra path appended
 */
function get_function_url($path = '')
{
	return get_theme_url('functions/' . ltrim($path, '/'));
}

/**
 * Get the theme module url and pass a string param to append to the end
 *  
 * @param  string   $path
 * @return string		  url to module with extra path appended
 */
function get_module_url($path = '')
{
	return get_function_url('modules/' . ltrim($path, '/'));
}