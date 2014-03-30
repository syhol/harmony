<?php

/**
 * Labeled input widget for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Sorcery_Widget_Labeled_Input extends Sorcery_Widget
{
	protected $template = 'sorcery-widgets:labeled-input';

	/**
	 * Setup the widget
	 * 
	 * @param string    $id      name of widget
	 * @param string    $value   value of widget
	 * @param boolean   $checked is the widget checked
	 * @param array     $data    widget data and config
	 */
	public function __construct($id, $value, $checked = false, $data = array()) {
		$this->id = $id;
		$data['value'] = (string)$value;
		$data['checked'] = (boolean)$checked;
		$data['widget'] = $this;
		$this->set_data($data);
	}

	/**
	 * Set some defaults with the passed data and save to instance
	 * 
	 * @return void
	 */
	public function set_data($data) {
		if ( 
			! isset($data['container_attributes']) || 
			! is_array($data['container_attributes'])
		) {
			$data['container_attributes'] = array();
		}

		if (
			! isset($data['container_attributes']['class']) || 
			! is_array($data['container_attributes']['class'])
		) {
			$data['container_attributes']['class'] = array();
		}

		return parent::set_data($data);
	}

	protected function prepare_data($data) {
		$data['attributes']['name'] = $this->id;
		$data['attributes']['value'] = $data['value'];

		if ( ! isset($data['label']) ) {
			$data['label'] = prettify($data['value']);
		}
		if ($data['checked']) {
			$data['attributes']['checked'] = 'checked';
		}

		$classes = $data['container_attributes']['class'];
		$data['container_attributes']['class'] = implode(' ', $classes);
		
		$attributes = array();
		foreach ($data['container_attributes'] as $key => $value) {
			$attributes[] = $key . '="' . $value . '"';
		}
		$data['container_attributes'] = implode(' ', $attributes);

		return parent::prepare_data($data);
	}
}
