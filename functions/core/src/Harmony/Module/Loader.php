<?php

/**
 * Harmony Module Loader
 *
 * @package  Harmony
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  1.0.0
 */
class Harmony_Module_Loader
{
	private $directories = array();

	private $factory;
	
	private $modules = array();
	
	public function __construct(array $directories, $factory = null)
	{
		foreach ($directories as $directory) {
			$this->directories[] = new DirectoryIterator($directory);
		}
		
		if ( ! $factory ) {
			$factory = new Harmony_Module_Factory;
		}

		$this->factory = $factory;
	}

	public function run()
	{
		$this->fetch_modules();
		$this->load_modules();
	}

	private function fetch_modules()
	{
		foreach ($this->directories as $directory) {
			foreach ($directory as $module_path) {
				if ( ! $module_path->isDot() && $module_path->isDir() ) {
					$module_file = $module_path->getPathname() . DS . $module_path->getFilename() . '.php';
				} elseif($module_path->isFile()) {
					$module_file = $module_path->getPathname();
				} else {
					continue;
				}
				$slug = $this->get_slug($module_file);
				if ( ! isset($this->modules[$slug]) ) {
					$this->modules[$slug] = $this->factory->new_module($module_file);
				}
			}
		}
	}

	private function get_slug($file)
	{
		$file = basename($file);
		if (defined('PATHINFO_FILENAME')) return pathinfo($file, PATHINFO_FILENAME);
	    if (strstr($file, '.')) return substr($file, 0, strrpos($file, '.'));
	}

	private function get_module($name)
	{
		$request = strtolower($name);
		foreach ($this->modules as $module) {
			$name = strtolower($module->get_name());
			$slug = strtolower($module->get_slug());
			$package = strtolower($module->get_package());
			if ($name === $request || $slug === $request || $package === $request) {
				return $module;
			}
		}
		return false;
	}

	private function load_modules()
	{
		foreach ($this->modules as $module) {
			$this->load_module($module);
		}
	}

	private function load_module($module)
	{
		$this->resolve_dependencies($module);
		$module->load();
	}

	private function resolve_dependencies($module)
	{
		foreach ($module->get_dependencies() as $dependency_name) {
			if ($dependency = $this->get_module($dependency_name)) {
				$this->load_module($dependency);
			} else {
				$name = $module->get_name();
				throw new ErrorException('Module "' . $name . '" could not find dependency "' . $dependency_name . '"');
			}
		}
	}

}