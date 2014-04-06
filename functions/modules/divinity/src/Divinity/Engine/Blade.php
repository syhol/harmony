<?php
/**
 * Divinity Template Engine
 *
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

class Divinity_Engine_Blade implements Divinity_Engine {

	private $env;

	public function __construct() {
		$directory = get_template_path();
		$upload_dir = wp_upload_dir();
		$cache = $upload_dir['basedir'] . '/cache/blade';
		$this->check_cache_dir($cache);
		
		$fs_directory = new Illuminate\Filesystem\Filesystem($directory);
		$blade = new Illuminate\View\Compilers\BladeCompiler($fs_directory, $cache);
		$blade = new Illuminate\View\Engines\CompilerEngine($blade);
		$engines = new Illuminate\View\Engines\EngineResolver;
		$engines->register('blade', function() use ($blade)
		{
			return $blade;
		});
		$finder = new Illuminate\View\FileViewFinder($fs_directory, array($directory));
		$dispatcher = new Illuminate\Events\Dispatcher(new Illuminate\Container\Container);
		$this->env = new Illuminate\View\Environment($engines, $finder, $dispatcher);
	}
	
	public function render($directory, $path, $data) {
		echo $this->compile($directory, $path, $data);
		return true;
	}
	
	public function compile($directory, $path, $data) {

		$fs_directory = new Illuminate\Filesystem\Filesystem($directory);
		$finder = new Illuminate\View\FileViewFinder($fs_directory, array($directory));
		$this->env->setFinder($finder);

		$path = str_replace($this->get_extension(), '', $path);
		return $this->env->make($path, $data);
	}
	
	public function get_extension() {
		return '.blade.php';
	}
	
	private function check_cache_dir($cache) {
		if( ! is_dir($cache) ) {
			mkdir($cache, 0666, true);
		}
	}

}