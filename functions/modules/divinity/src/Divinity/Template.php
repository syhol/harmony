<?php

/**
 * Class wrapper for the render and compile template functions
 * 
 * @package Template
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Divinity_Template implements ArrayAccess {
	
	public $template_directory = false;
	
	public $template = false;

	protected $data = array();

	protected $engine = array();

	/**
	 * Setup the template with required properties
	 *
	 * @param string          $template_directory
	 * @param string          $template
	 * @param Divinity_Engine $engine
	 * @param array           $data
	 */
	public function __construct($template_directory, $template, Divinity_Engine $engine, array $data = array()) {
		$this->template_directory = $template_directory;
		$this->template = $template;
		$this->data = $data;
		$this->engine = $engine;
	}

	/**
	 * Set the template engine
	 * 
	 * @param Divinity_Engine $template
	 * @return self
	 */
	public function set_engine(Divinity_Engine $engine) {
		$this->engine = $engine;
		return $this;
	}

	/**
	 * Get the template engine
	 * 
	 * @return string
	 */
	public function get_engine() {
		return $this->engine;
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
	public function bulk_set(array $data) {
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
		return $this->engine->render(
			$this->template_directory, 
			$this->template, 
			$this->data
		);
	}

	/**
	 * Compile and return the template markup
	 * 
	 * @return string
	 */
	public function compile() {
		return $this->engine->compile(
			$this->template_directory, 
			$this->template, 
			$this->data
		);	
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
