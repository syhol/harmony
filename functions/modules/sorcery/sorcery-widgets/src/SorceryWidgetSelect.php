<?php

/**
 * Select widget for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class SorceryWidgetSelect extends SorceryWidget
{
	protected $template = 'sorcery-widgets:select';

	/**
	 * Setup the widget
	 * 
	 * @param string	$id		 name of widget
	 * @param string	$value	  value of widget
	 * @param boolean   $checked	is the widget checked
	 * @param array	 $data	   widget data and config
	 */
	public function __construct($id, $value, $options = array(), $data = array())
	{
		$this->id = $id;
		$this->data = $data;
		$this->data['value'] = (string)$value;
		$this->data['options'] = (array)$options;
		$this->data['widget'] = $this;
	}

	protected function prepareData()
	{
		$this->data['attributes']['name'] = $this->id;
		$this->data['attributes']['class'][] = 'form-control';
		$this->data['item_template'] = 'sorcery-widgets:select-item';
	}
}
