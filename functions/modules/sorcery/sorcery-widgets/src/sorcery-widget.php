<?php

/**
 * Base class for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Sorcery_Widget implements ArrayAccess
{
	protected $id;

	protected $template = false;

	protected $data = array();

	/**
	 * Setup the widget
	 * 
	 * @param string $id   	name of widget
	 * @param string $value	value of widget
	 * @param array  $data  widget data and config
	 */
	public function __construct($id, $value, $data = array()) {
		$this->id = $id;
		$data['value'] = (string)$value;
		$data['widget'] = $this;
		$this->set_data($data);
	}

	/**
	 * Set the widget id
	 * 
	 * @param string $id
	 * @return self
	 */
	public function set_id($id) {
		$this->id = (string)$id;
		return $this;
	}

	/**
	 * Get the widget id
	 * 
	 * @return string
	 */
	public function get_id() {
		return $this->id;
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
	 * Set some defaults with the passed data and save to instance
	 * 
	 * @param array $data
	 * @return self
	 */
	public function set_data($data) {
		$data = (array)$data;
		if ( ! isset($data['attributes']) || ! is_array($data['attributes']) ) {
			$data['attributes'] = array();
		}
		if ( ! isset($data['attributes']['class']) || ! is_array($data['attributes']['class']) ) {
			$data['attributes']['class'] = array();
		}

		$this->data = $data;
		return $this;
	}

	/**
	 * Get the widget data
	 * 
	 * @return array
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * Render the widget markup
	 * 
	 * @return void
	 */
	public function render() {
		$data = $this->prepare_data($this->data);
		if ($this->template) {
			render_template($this->template, $data);
		} else {
			throw new ErrorException('No template set for widget "' . get_class($this) . '"');
		}
	}

	/**
	 * Compile and return the widget markup
	 * 
	 * @return string
	 */
	public function compile() {
		$data = $this->prepare_data($this->data);
		if ($this->template) {
			return compile_template($this->template, $data);
		} else {
			throw new ErrorException('No template set for widget "' . get_class($this) . '"');
		}
	}

	/**
	 * Prepare the data for the template to render
	 * 
	 * @return void
	 */
	protected function prepare_data($data) {

		$classes = $data['attributes']['class'];
		$data['attributes']['class'] = implode(' ', $classes);

		$attributes = array();
		foreach ($data['attributes'] as $key => $value) {
			$attributes[] = $key . '="' . $value . '"';
		}
		$data['attributes'] = implode(' ', $attributes);
		return $data;
	}

	public function offsetExists($index) {
		return isset($this->data[$index]);
	}

	public function offsetGet($index) {
		if($this->offsetExists($index)) {
			return $this->data[$index];
		}
		return false;
	}

	public function offsetSet($index, $value) {
		if($index) {
			array_dot_set($this->data, $index, $value);
		} else {
			$this->data[] = $value;
		}
		return true;

	}

	public function offsetUnset($index) {
		unset($this->data[$index]);
		return true;
	}

	public function __toString() {
		return $this->compile();
	}
}
