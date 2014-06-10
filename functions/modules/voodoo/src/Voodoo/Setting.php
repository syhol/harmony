<?php

/**
 * Class wrapper for terms
 * 
 * @package Voodoo
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Voodoo_Setting extends Glyph
{

	/**
	 * Context of the settings object
	 * 
	 * @var string
	 */
	protected static $context = '';

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
	public function __construct($data = array(), $context = '')
	{
		$this->data = $this->original = $data;
		$this->context = $context;
	}

	/**
	 * Set data
	 * 
	 * @param string $index key to save data to
	 * @param string $value data to set 
	 * @return self
	 */
	public function set($index, $value)
	{
		if ( ! empty($this->context) ) {
			$index = $this->context . '.' . $index;
		}
		list($first) = explode('.', $index);
		if ( ! isset($this->data[$first]) ) {
			$this->data[$first] = $this->original[$first] = get_option($first, array());
		}
		return parent::set($index, $value);
	}

	/**
	 * Get data
	 *
	 * @param string  $index   (optional) get data from key provided else return all data 
	 * @param mixed   $default (optional) returns when index not found 
	 * @param boolean $strict  (optional) passing false will fail if the value is empty 
	 * @return mixed
	 */
	public function get($index = null, $default = null, $strict = true)
	{
		if ( ! empty($this->context) ) {
			$index = $this->context . '.' . $index;
		}
		list($first) = explode('.', $index);
		if ( ! isset($this->data[$first]) ) {
			$this->data[$first] = $this->original[$first] = get_option($first, array());
		}
		return parent::get($index, $default, $strict);
	}


	/**
	 * Save setting data
	 * 
	 * @return self
	 */	
	public function save()
	{
		// Save new and changed values 
		foreach ($this->data as $key => $value) {
			if ( ! isset($this->original[$key]) || $value !== $this->original[$key]) {
				update_option($key, $value);
			}
		}

		// Delete removed values
		foreach ($this->original as $key => $value) {
			if ( ! isset($this->data[$key]) ) {
				delete_option($key);
			}
		}

		do_action('voodoo_setting_save', $this->data, $this->original, $this);

		return $this;
	}
}
