<?php

/**
 * Class wrapper for posts
 * 
 * @package Voodoo
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Voodoo_Post extends Glyph
{

	/**
	 * Array of WP_Post object keys that need to be saved using wp_update_post
	 * 
	 * @var array
	 */
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
	 * Array of original data
	 *  
	 * @var array
	 */
	protected $original = array();

	/**
	 * Setup the container with required properties
	 *
	 * @param array           $data
	 */
	public function __construct($data = array())
	{
		$this->data = $this->original = $data;
	}

	/**
	 * Save post meta and data
	 * 
	 * @return self
	 */	
	public function save()
	{
		$post_update = array();
		foreach ($this->data as $key => $value) {
			if ( ! isset($this->original[$key]) || $value !== $this->original[$key]) {
				// Save the new value to the database
				if(in_array($key, self::$post_keys)) {
					$post_update['ID'] = $this->data['ID'];
					$post_update[$key] = $value;
				} else {
					update_post_meta($this->data['ID'], $key, $value);
				}
			}
		}

		// Do all wp_update_post call in one go
		if ( ! empty($post_update) ) {
			wp_update_post($post_update);
		}

		$this->original = $this->data;

		return $this;
	}
}
