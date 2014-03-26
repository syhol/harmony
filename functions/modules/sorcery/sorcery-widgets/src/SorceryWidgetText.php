<?php

/**
 * Textbox widget for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class SorceryWidgetText extends SorceryWidget
{
	protected $template = 'sorcery-widgets:input';

	protected function prepareData()
	{
		if (isset($this->data['value'])) {
			$this->data['attributes']['value'] = $this->data['value'];
		}
		$this->data['attributes']['name'] = $this->id;
		$this->data['attributes']['type'] = 'text';
		$this->data['attributes']['class'][] = 'form-control';
	}
}
