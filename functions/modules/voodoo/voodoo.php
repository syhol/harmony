<?php
/**
 * Abstraction layer for data entities in wordpress
 * 
 * @package Voodoo
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 0.1.0
 */

function get($object, $index)
{
	return $object->get($index);
}

function post($id)
{
	if ($id instanceof WP_Query || is_array($id)) {
		if ($id instanceof WP_Query) {
			$posts = $id->get_posts(); // Is WP_Query
		} elseif (empty($id)) {
			$posts = array();          // Is empty
		} elseif (array_pop(array_values($id)) instanceof WP_Post) {
			$posts = $id;              // Is result of get_posts()
		} elseif (is_numeric(array_pop(array_values($id))) &&  is_numeric(array_pop(array_keys($id)))) {
			$posts = $id;              // Is an array of post id's
		} else {
			$posts = get_posts($id);   // Is WP_Query args
		}
		$collection = new Voodoo_Collection;
		foreach($posts as $post) {
			$collection[] = post($post);
		}
		return $collection;
	} elseif(is_numeric($id) || $id instanceof WP_Post) {
		// is a WP_Post or post id
		$data = array();
		$post = get_post($id);
		$meta = get_post_meta($post->ID);
		foreach ($meta as $key => $value) {
			if(is_array($value) && count($value) === 1 && isset($value[0])) {
				$value = array_pop($value);
			}
			$value = maybe_unserialize($value);
			if(is_string($value) && null !== ($jsond = json_decode($value, true))) {
				$value = $jsond;
			}
			$meta[$key] = $value;
		}
		$data = array_merge($data, $meta);
		$data = array_merge($data, (array)$post);
		return new Voodoo_Post($data);
	}
	
}

function term($id)
{
	
}

function user($id)
{
	
}

function setting($id)
{
	
}


/**
 * Add the voodoo oop structure to the psr-0 class loader
 * 
 * @return void
 */
function voodoo_init() {
	get_registry('autoloader.psr-0')->addNamespace('Voodoo', __DIR__ . '/src');
}
add_action('modules_loaded' , 'voodoo_init', 90);
