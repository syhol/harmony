<?php
/**
 * Divinity Template Engine
 *
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

class Divinity_Engine_Twig implements Divinity_Engine {

	/**
	 * Compile and output the template
	 * 
	 * @param string $directory
	 * @param string $path
	 * @param array  $data
	 * @return boolean
	 */
	public function render($directory, $path, $data) {
		echo $this->compile($directory, $path, $data);
		return true;
	}
	
	/**
	 * Compile and return the template
	 * 
	 * @param string $directory
	 * @param string $path
	 * @param array  $data
	 * @return string
	 */
	public function compile($directory, $path, $data) {
		$loader = new Twig_Loader_Filesystem($directory);
		$options = array(
			'cache' => $this->get_cache_dir()
		);
		$twig = new Twig_Environment($loader, $options);
		return $twig->loadTemplate($path)->render($data);
	}
	
	/**
	 * Return the file extension this engine supports, with the leading dot
	 * 
	 * @return string
	 */
	public function get_extension() {
		return '.twig';
	}
	
	/**
	 * Return the cache directory and create it if it doesn't exist
	 * 
	 * @return string
	 */
	private function get_cache_dir() {
		$upload_dir = wp_upload_dir();
		$cache = $upload_dir['basedir'] . '/cache/twig';
		if( ! is_dir($cache) ) {
			mkdir($cache, 0755, true);
		}
		return $cache;
	}

}