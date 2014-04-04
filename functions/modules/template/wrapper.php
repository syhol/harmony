<?php

/**
 * Class wrapper for the render and compile template functions
 * 
 * @package Template
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Template implements ArrayAccess {

	protected $template = false;

	protected $data = array();

	/**
	 * Setup the widget
	 * 
	 * @param string $id   	name of widget
	 * @param string $value	value of widget
	 * @param array  $data  widget data and config
	 */
	public function __construct($template = false, $data = array()) {
		$this->set_template($template);
		$this->set(null, $data);
	}

	/**
	 * Set the widget template
	 * 
	 * @param string $template
	 * @return self
	 */
	public function set_template($template) {
		$this->template = (string)$template;
		return $this;
	}

	/**
	 * Get the widget template
	 * 
	 * @return string
	 */
	public function get_template() {
		return $this->template;
	}

	/**
	 * Set the template data
	 * 
	 * @param string $key  key to save data to
	 * @param string $data data to set 
	 * @return self
	 */
	public function set($index, $data) {
		array_dot_set($this->data, $index, $data);
		return $this;
	}

	/**
	 * Set the template data from an array
	 * 
	 * @param string $data data to set 
	 * @return self
	 */
	public function bulk_set($data) {
		$data = array_dot($data);
		foreach ($data as $index => $item) {
			$this->set($index, $item);
		}
		return $this;
	}

	/**
	 * Get the template data
	 *
	 * @param string $key (optional) get data from key provided else return all data 
	 * @return array
	 */
	public function get($index = null) {
		if ( ! is_null($index) ) {
			return array_dot_get($this->data, $index);
		} else {
			return $this->data;
		}
	}

	/**
	 * Render the template markup
	 * 
	 * @return void
	 */
	public function render() {
		if ($this->template) {
			render_template($this->template, $this->data);
		} else {
			throw new ErrorException('No template set');
		}
	}

	/**
	 * Compile and return the template markup
	 * 
	 * @return string
	 */
	public function compile() {
		if ($this->template) {
			return compile_template($this->template, $this->data);
		} else {
			throw new ErrorException('No template set');
		}
	}

	/**
	 * See if data is set on this template
	 * 
	 * @param string|interger $index
	 * @return boolean
	 */
	public function offsetExists($index) {
		$data = array_dot($this->data);
		return isset($this->data[$index]);
	}

	/**
	 * get data from this template
	 * 
	 * @param string|interger $index
	 * @return mixed|false
	 */
	public function offsetGet($index) {
		if ($this->offsetExists($index)) {
			return $this->get($index);
		}
		return false;
	}

	/**
	 * set data to this template
	 * 
	 * @param string|interger $index
	 * @return boolean
	 */
	public function offsetSet($index, $value) {
		if ($index) {
			$this->set($index, $value);
		} else {
			$this->data[] = $value;
		}
		return true;

	}

	/**
	 * unset data from this template
	 * 
	 * @param string|interger $index
	 * @return boolean
	 */
	public function offsetUnset($index) {
		array_dot_forget($this->data, $index);
		return true;
	}

	/**
	 * Compile this template and return as a string
	 * 
	 * @param string|interger $index
	 */
	public function __toString() {
		return $this->compile();
	}
}
