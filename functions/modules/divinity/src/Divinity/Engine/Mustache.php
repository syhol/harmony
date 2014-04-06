<?php
/**
 * Divinity Template Engine
 *
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

class Divinity_Engine_Mustache implements Divinity_Engine {

	public function render($directory, $path, $data) {
		echo $this->compile($directory, $path, $data);
		return true;
	}
	
	public function compile($directory, $path, $data) {
		$path = str_replace($this->get_extension(), '', $path);
		$loader = new Mustache_Loader_FilesystemLoader($directory);
		$upload_dir = wp_upload_dir();
		$cache = $upload_dir['basedir'] . '/cache/mustache';
		$options = array(
			'loader' => $loader,
			'cache' => $cache
		);
		$mustache = new Mustache_Engine($options);
		return $mustache->loadTemplate($path)->render($data);
	}
	
	public function get_extension() {
		return '.mustache';
	}

}