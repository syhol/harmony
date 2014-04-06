<?php
/**
 * Divinity Template Engine
 *
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

class Divinity_Engine_Twig implements Divinity_Engine {

	public function render($directory, $path, $data) {
		echo $this->compile($directory, $path, $data);
		return true;
	}
	
	public function compile($directory, $path, $data) {
		$loader = new Twig_Loader_Filesystem($directory);
		$upload_dir = wp_upload_dir();
		$options = array(
			'cache' => $upload_dir['basedir'] . '/cache/twig'
		);
		$twig = new Twig_Environment($loader, $options);
		return $twig->loadTemplate($path)->render($data);
	}
	
	public function get_extension() {
		return '.twig';
	}

}