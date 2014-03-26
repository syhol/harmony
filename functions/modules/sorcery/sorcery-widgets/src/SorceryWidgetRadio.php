<?php

/**
 * Radio widget for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class SorceryWidgetRadio extends SorceryWidget
{
	protected $template = 'sorcery-widgets:labeled-input';

	/**
	 * Setup the widget
	 * 
	 * @param string	$id		 name of widget
	 * @param string	$value	  value of widget
	 * @param boolean   $checked	is the widget checked
	 * @param array	 $data	   widget data and config
	 */
	public function __construct($id, $value, $checked = false, $data = array())
	{
		$this->id = $id;
		$this->data = $data;
		$this->data['value'] = (string)$value;
		$this->data['checked'] = (boolean)$checked;
		$this->data['widget'] = $this;
	}

	/**
	 * Pre Prepare the data for the template to render
	 * 
	 * @return void
	 */
	protected function prePrepareData()
	{
		parent::prePrepareData();

		if ( 
			! isset($this->data['container_attributes']) || 
			! is_array($this->data['container_attributes'])
		) {
			$this->data['container_attributes'] = array();
		}

		if ( 
			! isset($this->data['container_attributes']['class']) || 
			! is_array($this->data['container_attributes']['class'])
		) {
			$this->data['container_attributes']['class'] = array();
		}
	}

	protected function prepareData()
	{
		$this->data['attributes']['name'] = $this->id;
		$this->data['attributes']['value'] = $this->data['value'];

		if ( ! isset($this->data['label']) ) {
			$this->data['label'] = prettify($this->data['value']);
		}
		if ($this->data['checked']) {
			$this->data['attributes']['checked'] = 'checked';
		}

		$this->data['attributes']['type'] = 'radio';
		$this->data['container_attributes']['class'][] = 'radio';
	}

	/**
	 * Post Prepare the data for the template to render
	 * 
	 * @return void
	 */
	protected function postPrepareData()
	{
		$classes = $this->data['container_attributes']['class'];
		$this->data['container_attributes']['class'] = implode(' ', $classes);
		
		$attributes = array();
		foreach ($this->data['container_attributes'] as $key => $value) {
			$attributes[] = $key . '="' . $value . '"';
		}
		$this->data['container_attributes'] = implode(' ', $attributes);

		parent::postPrepareData();
	}
}
