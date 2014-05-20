<?php
/**
 * Divinity Template Engine
 *
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

class Divinity_Engine_PHP implements Divinity_Engine
{

	/**
	 * Compile and output the template
	 * 
	 * @param string $directory
	 * @param string $path
	 * @param array  $data
	 * @return boolean
	 */
	public function render($template_dir, $template, $data)
	{
		extract($data);
		require($template_dir . $template);
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
	public function compile($template_dir, $template, $data)
	{
		extract($data);
		ob_start();
		require($template_dir . $template);
		return ob_get_clean();
	}
	
	/**
	 * Return the file extension this engine supports, with the leading dot
	 * 
	 * @return string
	 */
	public function get_extension()
	{
		return '.php';
	}

}