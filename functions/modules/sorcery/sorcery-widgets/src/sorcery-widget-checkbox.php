<?php

/**
 * Checkbox widget for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Sorcery_Widget_Checkbox extends Sorcery_Widget_Labeled_Input
{
	protected $template = 'sorcery-widgets:labeled-input';

	protected function prepare_data($data) {
		$data['attributes']['type'] = 'checkbox';
		$data['container_attributes']['class'][] = 'checkbox';

		return parent::prepare_data($data);
	}
}
