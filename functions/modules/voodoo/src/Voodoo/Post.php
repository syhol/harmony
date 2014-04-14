<?php

/**
 * Class wrapper for posts
 * 
 * @package Voodoo
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Voodoo_Post extends Voodoo_Entity {

	protected static $post_keys = array(
		'ID',
		'post_author',
		'post_date',
		'post_date_gmt',
		'post_content',
		'post_title',
		'post_excerpt',
		'post_status',
		'comment_status',
		'ping_status',
		'post_password',
		'post_name',
		'to_ping',
		'pinged',
		'post_modified',
		'post_modified_gmt',
		'post_content_filtered',
		'post_parent',
		'guid',
		'menu_order',
		'post_type',
		'post_mime_type',
		'comment_count',
		'filter',
	);

	/**
	 * Save post meta and data
	 * 
	 * @param string $index key to save data to
	 * @param string $data  data to set 
	 * @return self
	 */	
	public function set($index, $data) {
		// Set the data like standard
		parent::set($index, $data);

		// Get the index and new value at the top level
		$value = $this->get($index);
		if (str_contains($index, '.')) {
			$indexes = explode('.', $index);
			$index = array_shift($indexes);
			$value = $this->get($index);
		}

		// Save the new value to the database
		if(in_array($index, self::$post_keys)) {
			wp_update_post(array('ID' => $this->data['ID'], $index => $value));
		} else {
			update_post_meta($this->data['ID'], $index, $value);
		}
		return $this;
	}
}
