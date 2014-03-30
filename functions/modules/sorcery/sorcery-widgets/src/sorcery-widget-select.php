<?php

/**
 * Select widget for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Sorcery_Widget_Select extends Sorcery_Widget {
	
	protected $template = 'sorcery-widgets:select';

	/**
	 * Setup the widget
	 * 
	 * @param string            	$id   		 name of widget
	 * @param string            	$value	  value of widget
	 * @param boolean   $checked	is the widget checked
	 * @param array             	 $data	   widget data and config
	 */
	public function __construct($id, $value, $options = array(), $data = array()) {
		$this->id = $id;
		$data['value'] = (string)$value;
		$data['options'] = (array)$options;
		$data['widget'] = $this;
		$this->set_data($data);
	}

	protected function prepare_data($data) {
		$data['attributes']['name'] = $this->id;
		$data['attributes']['class'][] = 'form-control';
		$data['item_template'] = 'sorcery-widgets:select-item';
		return parent::prepare_data($data);
	}
}
