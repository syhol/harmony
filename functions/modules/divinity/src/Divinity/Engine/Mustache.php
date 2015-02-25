<?php
/**
 * Divinity Template Engine
 *
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

class Divinity_Engine_Mustache implements Divinity_Engine
{

	/**
	 * Compile and output the template
	 * 
	 * @param string $directory
	 * @param string $path
	 * @param array  $data
	 * @return boolean
	 */
	public function render($directory, $path, $data)
	{
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
	public function compile($directory, $path, $data)
	{
		$path = str_replace($this->get_extension(), '', $path);
		$loader = new Mustache_Loader_FilesystemLoader($directory);
		$options = array(
			'loader' => $loader,
			'cache' => $this->get_cache_dir()
		);
		$mustache = new Mustache_Engine($options);
		return $mustache->loadTemplate($path)->render($data);
	}
	
	/**
	 * Return the file extensions this engine supports, with the leading dot
	 * 
	 * @return array
	 */
	public function get_extensions()
	{
		return array('.mustache');
	}

	/**
	 * Return the cache directory and create it if it doesn't exist
	 * 
	 * @return string
	 */
	private function get_cache_dir()
	{
		$upload_dir = wp_upload_dir();
		$cache = $upload_dir['basedir'] . '/cache/mustache';
		if( ! is_dir($cache) ) {
			mkdir($cache, 0755, true);
		}
		return $cache;
	}

}