<?php

/**
 * Class wrapper for posts
 * 
 * @package Voodoo
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Voodoo_User extends Glyph
{

	/**
	 * Array of WP_User object keys
	 * 
	 * @var array
	 */
	protected static $user_keys = array(
		'ID',
		'user_login',
		'user_pass',
		'user_nicename',
		'user_email',
		'user_url',
		'user_registered',
		'user_activation_key',
		'user_status',
		'display_name'
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
	 * Save user meta and data
	 * 
	 * @return self
	 */	
	public function save()
	{
		// Save new and changed values
		$user_update = array();
		foreach ($this->data as $key => $value) {
			if ( ! isset($this->original[$key]) || $value !== $this->original[$key]) {
				// Save the new value to the database
				if(in_array($key, self::$user_keys)) {
					$user_update['ID'] = $this->data['ID'];
					$user_update[$key] = $value;
				} else {
					update_user_meta($this->data['ID'], $key, $value);
				}
			}
		}

		// Delete removed values
		foreach ($this->original as $key => $value) {
			if ( ! isset($this->data[$key]) ) {
				if(in_array($key, self::$user_keys)) {
					$user_update['ID'] = $this->data['ID'];
					$user_update[$key] = null;
				} else {
					delete_user_meta($this->data['ID'], $key);
				}
			}
		}
		
		// Do all wp_update_post call in one go
		if ( ! empty($user_update) ) {
			wp_update_user($user_update);
		}
		
		do_action('voodoo_user_save', $this->data, $this->original, $this);

		$this->original = $this->data;
		
		return $this;
	}
}
