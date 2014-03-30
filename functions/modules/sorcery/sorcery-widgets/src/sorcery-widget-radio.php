<?php

/**
 * Radio widget for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Sorcery_Widget_Radio extends Sorcery_Widget_Labeled_Input
{
	protected $template = 'sorcery-widgets:labeled-input';

	protected function prepare_data($data) {
		$data['attributes']['type'] = 'radio';
		$data['container_attributes']['class'][] = 'radio';
		
		return parent::prepare_data($data);
	}
}
