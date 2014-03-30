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

require('src/sorcery-widget.php');
require('src/sorcery-widget-text.php');
require('src/sorcery-widget-textarea.php');
require('src/sorcery-widget-labeled-input.php');
require('src/sorcery-widget-radio.php');
require('src/sorcery-widget-checkbox.php');
require('src/sorcery-widget-select.php');

function sorcery_widget_text($name, $value, $data = array()) {
	$widget = new Sorcery_Widget_Text($name, $value, $data);
	$widget->render();
}

function sorcery_widget_textarea($name, $value, $data = array()) {
	$widget = new Sorcery_Widget_Textarea($name, $value, $data);
	$widget->render();
}

function sorcery_widget_radio($name, $value, $checked = false, $data = array()) {
	$widget = new Sorcery_Widget_Radio($name, $value, $checked, $data);
	$widget->render();
}

function sorcery_widget_checkbox($name, $value, $checked = false, $data = array()) {
	$widget = new Sorcery_Widget_Checkbox($name, $value, $checked, $data);
	$widget->render();
}

function sorcery_widget_select($name, $value, $options = array(), $data = array()) {
	$widget = new Sorcery_Widget_Select($name, $value, $options, $data);
	$widget->render();
}