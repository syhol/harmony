<?php
/**
 * Sorcery Widgets Module
 *
 * Module to generate awesome form widgets
 * 
 * @package Sorcery
 * @subpackage Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */


function sorcery_widget_text($data = array()) {
	$data = sorcery_widget_default_attrs($data);

	$data['attributes']['value'] = isset($data['value']) ? $data['value'] : '';
	$data['attributes']['name'] = isset($data['id']) ? $data['id'] : '';
	$data['attributes']['type'] = 'text';
	$data['attributes']['class'][] = 'form-control';

	return new Template('sorcery-widgets:input', $data);
}

function sorcery_widget_textarea($data = array()) {
	$data = sorcery_widget_default_attrs($data);

	$data['value'] = isset($data['value']) ? $data['value'] : '';
	$data['attributes']['name'] = isset($data['id']) ? $data['id'] : '';
	$data['attributes']['class'][] = 'form-control';

	return new Template('sorcery-widgets:textarea', $data);
}

function sorcery_widget_radio($data = array()) {
	$data = sorcery_widget_default_attrs($data);
	$data = sorcery_widget_default_attrs($data, 'container_attributes');

	$data['container_attributes']['class'][] = 'radio';
	$data['attributes']['value'] = isset($data['value']) ? $data['value'] : '';
	$data['attributes']['name'] = isset($data['id']) ? $data['id'] : '';
	$data['attributes']['type'] = 'radio';
	$val = $data['attributes']['value'];
	$data['label'] = isset($data['label']) ? $data['label'] : prettify($val);
	if (isset($data['checked']) && $data['checked']) {
		$data['attributes']['checked'] = 'checked';
	}

	return new Template('sorcery-widgets:labeled-input', $data);
}

function sorcery_widget_checkbox($data = array()) {
	$data = sorcery_widget_default_attrs($data);
	$data = sorcery_widget_default_attrs($data, 'container_attributes');

	$data['container_attributes']['class'][] = 'checkbox';
	$data['attributes']['value'] = isset($data['value']) ? $data['value'] : '';
	$data['attributes']['name'] = isset($data['id']) ? $data['id'] : '';
	$data['attributes']['type'] = 'checkbox';
	$val = $data['attributes']['value'];
	$data['label'] = isset($data['label']) ? $data['label'] : prettify($val);
	if (isset($data['checked']) && $data['checked']) {
		$data['attributes']['checked'] = 'checked';
	}

	return new Template('sorcery-widgets:labeled-input', $data);
}

function sorcery_widget_select($data = array()) {
	$data = sorcery_widget_default_attrs($data);

	$data['attributes']['name'] = isset($data['id']) ? $data['id'] : '';
	$data['attributes']['class'][] = 'form-control';
	$data['item_template'] = 'sorcery-widgets:select-item';

	return new Template('sorcery-widgets:select', $data);
}

function sorcery_widget_default_attrs($data, $key = 'attributes') {
	if ( ! isset($data[$key]) || ! is_array($data[$key]) ) {
		$data[$key] = array();
	}
	if ( ! isset($data[$key]['class']) || ! is_array($data[$key]['class']) ) {
		$data[$key]['class'] = array();
	}
	return $data;
}


