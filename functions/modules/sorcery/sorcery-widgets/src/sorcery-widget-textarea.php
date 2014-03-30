<?php

/**
 * Textarea widget for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Sorcery_Widget_Textarea extends Sorcery_Widget
{
	protected $template = 'sorcery-widgets:textarea';

	protected function prepare_data($data) {
		if (isset($data['value'])) {
			$data['attributes']['value'] = $data['value'];
		}
		$data['attributes']['name'] = $this->id;
		$data['attributes']['class'][] = 'form-control';
		return parent::prepare_data($data);
	}
}
