<?php
/**
 * Divinity Template Engine
 *
 * @package Divinity
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

class Divinity_Engine_Blade implements Divinity_Engine {

	/**
	 * An instance of the View environment
	 * @var Illuminate\View\Environment
	 */
	private $env;
	
	/**
	 * An instance of the Blade compiler
	 * @var Illuminate\View\Compilers\BladeCompiler
	 */
	private $blade;

	public function __construct() {
		$fs = new Illuminate\Filesystem\Filesystem;
		$this->blade = new Illuminate\View\Compilers\BladeCompiler($fs, $this->get_cache_dir());
		$blade_engine = new Illuminate\View\Engines\CompilerEngine($this->blade);
		$engines = new Illuminate\View\Engines\EngineResolver;
		$engines->register('blade', function() use ($blade_engine)
		{
			return $blade_engine;
		});
		$finder = new Illuminate\View\FileViewFinder($fs, array(get_template_path()));
		$dispatcher = new Illuminate\Events\Dispatcher(new Illuminate\Container\Container);
		$this->env = new Illuminate\View\Environment($engines, $finder, $dispatcher);
		
		$this->set_wp_extensions();
	}
	
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
		$fs = $this->env->getFinder()->getFilesystem();
		$finder = new Illuminate\View\FileViewFinder($fs, array($directory));
		$this->env->setFinder($finder);

		$path = str_replace($this->get_extension(), '', $path);
		return $this->env->make($path, $data);
	}
	
	/**
	 * Return the file extension this engine supports, with the leading dot
	 * 
	 * @return string
	 */
	public function get_extension() {
		return '.blade.php';
	}
	
	/**
	 * Return the cache directory and create it if it doesn't exist
	 * 
	 * @return string
	 */
	private function get_cache_dir() {
		$upload_dir = wp_upload_dir();
		$cache = $upload_dir['basedir'] . '/cache/blade';
		if( ! is_dir($cache) ) {
			mkdir($cache, 0755, true);
		}
		return $cache;
	}
	
	/**
	 * Set up blade extensions
	 *
	 * @return void
	 */
	private function set_wp_extensions() {
		
		$this->blade->extend(function($view, $compiler) {
			$pattern = $compiler->createMatcher('harmonyRender');
			
			return preg_replace($pattern, '$1<?php render_template($2) ?>', $view);
		});
		
		$this->blade->extend(function($view, $compiler) {
			$pattern = $compiler->createPlainMatcher('harmonyPosts');
			
			return preg_replace($pattern, '<?php if(have_posts()) : while(have_posts()) : the_post(); ?>', $view);
		});
		
		$this->blade->extend(function($view, $compiler) {
			$pattern = $compiler->createPlainMatcher('harmonyEndPosts');
			
			return preg_replace($pattern, '<?php endwhile; endif; ?>', $view);
		});
	}
}