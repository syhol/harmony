<?php

/**
 * Class wrapper for the render and compile template functions
 * 
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Divinity_Template extends Glyph {
	
	/**
	 * Template directory where a collection of templates are stored
	 * 
	 * @var boolean|string
	 */
	public $template_directory = false;
	
	/**
	 * Template location within the template directory
	 * 
	 * @var boolean|string
	 */
	public $template = false;
	
	/**
	 * Template engine for the template
	 * 
	 * @var Divinity_Engine
	 */
	protected $engine;

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
	 * Compile this template and return as a string
	 * 
	 * @param string|interger $index
	 */
	public function __toString() {
		return $this->compile();
	}
}
