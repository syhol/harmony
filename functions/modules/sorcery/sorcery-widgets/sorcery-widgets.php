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

require('src/SorceryWidget.php');
require('src/SorceryWidgetText.php');
require('src/SorceryWidgetTextarea.php');
require('src/SorceryWidgetRadio.php');
require('src/SorceryWidgetCheckbox.php');
require('src/SorceryWidgetSelect.php');

function sorcery_widget_text($name, $value, $data = array()) {
	$widget = new SorceryWidgetText($name, $value, $data);
	$widget->render();
}

function sorcery_widget_textarea($name, $value, $data = array()) {
	$widget = new SorceryWidgetTextarea($name, $value, $data);
	$widget->render();
}

function sorcery_widget_radio($name, $value, $checked = false, $data = array()) {
	$widget = new SorceryWidgetRadio($name, $value, $checked, $data);
	$widget->render();
}

function sorcery_widget_checkbox($name, $value, $checked = false, $data = array()) {
	$widget = new SorceryWidgetCheckbox($name, $value, $checked, $data);
	$widget->render();
}

function sorcery_widget_select($name, $value, $options = array(), $data = array()) {
	$widget = new SorceryWidgetSelect($name, $value, $options, $data);
	$widget->render();
}