<?php
/**
 * Sorcery Config
 * 
 * @package Sorcery
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 0.0.1
 */

return array(
	'all' => array(
		'sorcery' => array(
			'validation' => array(
				'rules' => array(
					'required' => 'sorcery_layout_general',
					'pattern'  => 'sorcery_layout_horizontal'
				),
				'messages' => array(
					'required' => 'This field is required',
					'pattern'  => 'This field is invalid'
				),
			),
			'layouts' => array(
				'factory-bindings' => array(
					'general'     => 'sorcery_layout_general',
					'horizontal'  => 'sorcery_layout_horizontal'
				)
			),
			'widgets' => array(
				'factory-bindings' => array(
					'text'     => 'sorcery_widget_text',
					'textarea' => 'sorcery_widget_textarea',
					'radio'    => 'sorcery_widget_radio',
					'checkbox' => 'sorcery_widget_checkbox',
					'select'   => 'sorcery_widget_select'
				)
			)
		)
	)
);