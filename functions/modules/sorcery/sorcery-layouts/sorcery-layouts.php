<?php
/**
 * Sorcery Layouts Module
 *
 * Module to generate cool field layout for widgets, lables, errors and more...
 * 
 * @package Sorcery
 * @subpackage Sorcery_Layouts
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */


function sorcery_layout_general($data = array())
{
	$data = sorcery_widget_default_attrs($data);
	$data = sorcery_layout_standard_data($data);

	return template('sorcery-layouts:general', $data);
}

function sorcery_layout_horizontal($data = array())
{
	$data = sorcery_widget_default_attrs($data);
	$data = sorcery_layout_standard_data($data);

	return template('sorcery-layouts:horizontal', $data);
}

function sorcery_layout_standard_data($data = array())
{
	$data = sorcery_widget_default_attrs($data);

	$data['attributes']['class'][] = 'form-group';
	$data['help']   = isset($data['help'])   ? $data['help']   : false ;
	$data['label']  = isset($data['label'])  ? $data['label']  : false ;
	$data['widget'] = isset($data['widget']) ? $data['widget'] : false ;
	$data['errors'] = isset($data['errors']) ? $data['errors'] : false ;

	if ($data['errors']) {
		$data['attributes']['class'][] = 'has-error';
	}
	if (is_array($data['errors'])) {
		$open = '<p><span class="fa fa-exclamation-circle">&nbsp;</span>';
		$close = '</p>';
		$center = $close . $open;
		$data['errors'] = $open . implode($center, $data['errors']) . $close;
	}

	return $data;
}