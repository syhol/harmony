<?php
/**
 * Meta function for the registry module
 *
 * @package Registry
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

/**
 * Get and set the registry meta
 * 
 * Pass in a new meta to replace the active meta. The old
 * meta will then be returned so it can be reinserted later. To just
 * get the active meta, call the function with no parameters.
 *
 * @param   mixed   $new_meta   a new meta
 * @return  mixed               the active meta (likely an array)
 */
function registry_meta($new_meta = null) {
    static $registry_meta = array();    
    $returned_meta = $registry_meta;
    if ( ! empty($new_meta) ) {
        $registry_meta = $new_meta;
    }
    return $returned_meta;
}


/**
 * Set a registry meta variable
 *
 * You can use array dot notation
 * 
 * @see array_dot_set()
 * @param   string  $key
 * @param   mixed   $value 
 * @return  void
 */
function set_registry_meta($key, $value) {
    $registry = registry_meta();
    array_dot_set($registry, $key, $value);
    registry_meta($registry);
}

/**
 * Get a registry meta variable
 * 
 * You can use array dot notation
 * 
 * @see array_dot_get()
 * @param   string  $key
 * @param   misex   $default default value to return if none found
 * @return  mixed
 */
function get_registry_meta($key, $default = null) {
    $registry = registry_meta();
    return array_dot_get($registry, $key, $default);
}

/**
 * Add a new registry file to the registry meta
 * 
 * @param   mixed   $new_meta   a new meta
 * @return  mixed               the active meta (likely an array)
 */
function add_registry_file($file_path) {
    $files = get_registry_meta('files', array());
    $files[] = $file_path;
    set_registry_meta('files', $files);
}

/**
 * Remove a registry file from the registry meta
 * 
 * @param   mixed   $new_meta   a new meta
 * @return  mixed               the active meta (likely an array)
 */
function remove_registry_file($file_path) {
    $files = get_registry_meta('files', array());
    $pos = array_search($file_path, $files);
    if ($pos === false) {
        unset($files[$pos]);
    }
    set_registry_meta('files', $files);
}

/**
 * Get all registry files
 * 
 * @return  array
 */
function get_registry_files() {
    return get_registry_meta('files', array());
}