<?php
/**
 * Abstraction layer for data entities in wordpress
 * 
 * @package Voodoo
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @uses    Glyph
 * @version 0.1.0
 */

function get($object, $index)
{
	return $object->get($index);
}

function post($id)
{

	// Try to build a Voodoo_Post from passed value 
	if(is_numeric($id) || $id instanceof WP_Post) {
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
		$data = apply_filters('voodoo_post_data', $data);
		return new Voodoo_Post($data);
	}

	// Not a post id or post object, but maybe a post query or array of posts
	if ($id instanceof WP_Query) {
		$posts = $id->get_posts();
		$collection = new Voodoo_Collection;
		foreach($posts as $post) {
			$collection[] = post($post);
		}
	}
	if(is_array($id)) {
		$values = array_values($id);
		$keys = array_keys($id);
		$first_value = array_pop($values);
		$first_key = array_pop($keys);
		if (empty($id)) {
			return null;               // Is empty
		} elseif ($first_value instanceof WP_Post) {
			$posts = $id;              // Is result of get_posts()
		} elseif (is_numeric($first_key) &&  is_numeric($first_value)) {
			$posts = $id;              // Is an array of post id's
		} else {
			$posts = get_posts($id);   // Is WP_Query args
		}
		$collection = new Voodoo_Collection;
		foreach($posts as $post) {
			$collection[] = post($post);
		}
		return $collection;
	}
	
}

function term($id)
{
	// Try to build a Voodoo_Term from passed value
	$term = null;
	if (is_object($id) && isset($id->term_id)) {
		$term = $id;
	}
	if (is_numeric($id)) {
		global $wpdb;
		$taxonomy = $wpdb->get_var($wpdb->prepare( "SELECT tt.taxonomy FROM $wpdb->term_taxonomy AS tt WHERE tt.term_id = %s LIMIT 1", $id));
		$term = get_term($id, $taxonomy);
	}
	if ($term) {
		$data = array();
		$data = array_merge($data, (array)$term);
		$data = apply_filters('voodoo_term_data', $data);
		return new Voodoo_Term($data);
	}

	// Not a term id or term object, but maybe a term query or array of terms
	if (is_array($id) && ! empty($id)) {
		$terms = array();
		$values = array_values($id);
		$keys = array_keys($id);
		$first_value = array_pop($values);
		$first_key = array_pop($keys);
		if (empty($id)) {
			return null;               // Is empty
		} elseif (array_key_exists('term_id', $first_value)) {
			$terms = $id;              // Is result of get_terms()
		} elseif (is_numeric($first_key) &&  is_numeric($first_value)) {
			$terms = $id;              // Is an array of term id's
		}
		$collection = new Voodoo_Collection;
		foreach($terms as $term) {
			$collection[] = term($term);
		}
		return $collection;
	}
}

function user($id)
{
	// Try to build a Voodoo_User from passed value 
	if(is_numeric($id) || $id instanceof WP_User) {
		// is a WP_User or user id
		$data = array();
		$user = new WP_User($id);
		$meta = get_user_meta($user->ID);
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
		$data = array_merge($data, (array)$user->data);
		$data = apply_filters('voodoo_user_data', $data);
		return new Voodoo_User($data);
	}

	// Not a user id or user object, but maybe a user query or array of users
	if ($id instanceof WP_User_Query) {
			$id->set('fields', 'all_with_meta');
			$users = $id->get_results(); // Is WP_User_Query
	}
	if(is_array($id)) {
		$values = array_values($id);
		$keys = array_keys($id);
		$first_value = array_pop($values);
		$first_key = array_pop($keys);
		if (empty($id)) {
			return null;               // Is empty
		} elseif ($first_value instanceof WP_User) {
			$users = $id;              // Collection of WP_Users
		} elseif (is_numeric($first_key) && is_numeric($first_value)) {
			$users = $id;              // Is an array of user id's
		} else {
			$user_query = new WP_User_Query($id);   // Is WP_User_Query args
			$user_query->set('fields', 'all_with_meta');
			$users = $user_query->get_results();
		}
		$collection = new Voodoo_Collection;
		foreach($users as $user) {
			$collection[] = user($user);
		}
		return $collection;
	}
}

function setting($id = null)
{
	$data = array();
	if ($id) {
		list($first) = explode('.', $id);
		$data = get_option($first, array());
	} else {
		$id = '';
	}
	return new Voodoo_Setting($data, $id);
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
