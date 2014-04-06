<?php
/**
 * Divinity Template Engine
 *
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

class Divinity_Engine_PHP implements Divinity_Engine {

	public function render($template_dir, $template, $data) {
		extract($data);
		require($template_dir . $template);
		return true;
	}
	
	public function compile($template_dir, $template, $data) {
		extract($data);
		ob_start();
		require($template_dir . $template);
		return ob_get_clean();
	}
	
	public function get_extension() {
		return '.php';
	}

}