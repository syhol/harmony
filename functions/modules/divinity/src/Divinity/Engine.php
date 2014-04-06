<?php
/**
 * Divinity Template Engine
 *
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

interface Divinity_Engine {
	public function render($template_dir, $template, $data);
	public function compile($template_dir, $template, $data);
	public function get_extension();
}