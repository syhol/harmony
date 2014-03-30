<?php
/**
 * Functions for the config module
 *
 * @package Registry
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

/**
 * Get and set the registry container
 * 
 * Pass in a new container to replace the active container. The old
 * container will then be returned so it can be reinserted later. To just
 * get the active container, call the function with no parameters.
 *
 * @param   mixed   $new_container  a new registry container
 * @return  mixed				   the active registry container (likely an array)
 */
function registry_container($new_container = null) {
	static $registry_container = array();	
	$returned_container = $registry_container;
	if ( ! empty($new_container) ) {
		$registry_container = $new_container;
	}
	return $returned_container;
}

/**
 * Set a registry variable
 *
 * You can use array dot notation
 * 
 * @see array_dot_set()
 * @param   string  $key
 * @param   mixed   $value 
 * @return  void
 */
function set_registry($key, $value) {
	$registry = registry_container();
	array_dot_set($registry, $key, $value);
	registry_container($registry);
}

/**
 * Get a registry variable
 * 
 * You can use array dot notation
 * 
 * @see array_dot_get()
 * @param   string  $key
 * @param   misex   $default default value to return if none found
 * @return  mixed
 */
function get_registry($key, $default = null) {
	$registry = registry_container();
	return array_dot_get($registry, $key, $default);
}

/**
 * Push an entry to a registry array variable
 * 
 * You can use array dot notation
 * 
 * @see array_dot_get()
 * @see array_dot_set()
 * @param   string  $key
 * @param   mixed   $value 
 * @return  mixed
 */
function push_registry($key, $value) {
	$array = get_registry($key, array());
	if ( ! is_array($array) ) $array = array();
	array_push($array, $value);
	array_dot_set($key, $array);
}

/**
 * Pull an entry from registry and delete it
 * 
 * You can use array dot notation
 * 
 * @see array_dot_get()
 * @see array_dot_set()
 * @param   string  $key
 * @param   mixed   $value 
 * @return  mixed
 */
function pull_registry($key, $index = null) {
	$registry = registry_container();
	if ( ! is_null($index) ) $key .= '.' . $index;
	$value = array_dot_get($registry, $key, null);
	array_dot_forget($registry, $key);
	array_dot_set($registry, $key, $value);
	registry_container($registry);
	return $value;
}

/**
 * Empty the config container and return the old one
 * 
 * @return mixed	old registry container
 */
function reset_registry() {
	return registry_container(array());
}

/**
 * Load an array into the registry container via set_config()
 *
 * Does not delete old values unless they are overridden
 * 
 * @see set_registry()
 * @param array $config
 * @return void
 */
function load_registry(array $items) {
	$items = array_dot($items);
	foreach ($items as $key => $value) {
		set_registry($key, $value);
	}
}

/**
 * Load an array from the config.php into the config variable
 * 
 * @see load_registry()
 * @param  string $env defaults to whats in the ENV constant
 * @return void
 */
function load_environment_registry($env = null) {
	if (is_null($env)) {
		if ( ! defined('ENV') ) {
			return;
		}
		$env = ENV;
	}

	$files = get_registry_files();
	foreach ($files as $file) {
		$registry = require($file);
		if (isset($registry[$env])) {
			load_registry($registry[$env]);
		}
	}
}
