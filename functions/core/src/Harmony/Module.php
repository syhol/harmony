<?php

/**
 * Harmony Module
 *
 * @package  Harmony
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  1.0.0
 */
class Harmony_Module
{
	private $file;
	
	private $slug;

	private $name;

	private $package;

	private $description;

	private $tags = array();

	private $dependencies = array();

	private $loaded = false;
	
	public function __construct($file)
	{
		$this->file = $file;
		$this->slug = basename($file);
		list($this->slug) = explode('.', $this->slug);

		$lastupdated = @filemtime($file);
		if ( ! $lastupdated ) {
			throw new ErrorException('Module file ' . $file . ' not found');
		}

		$cache = get_option('harmony.module.cache');
		if (isset($cache[$this->slug]) && $cache[$this->slug]['time'] >= $lastupdated) {
			$this->load_cache($cache[$this->slug]);
		} else {
			$this->parse_file();
			$this->save_cache();
		}
	}

	public function load()
	{
		if ( ! $this->loaded ) { 
			$this->loaded = true;
			require($this->file);
		}
	}

	public function get_name()
	{
		return $this->name;
	}

	public function get_slug()
	{
		return $this->slug;
	}

	public function get_package()
	{
		return $this->package;
	}

	public function get_dependencies()
	{
		return $this->dependencies;
	}

	private function parse_file()
	{
		$contents = file_get_contents($this->file);
		$contents = str_replace('<?php', '', $contents);
		$contents = trim($contents);
		if (substr($contents, 0, 3) === '/**') {
			$endpos = strpos($contents, '*/') + 2;
			$docblock = substr($contents, 0, $endpos);
			$this->parse_docblock($docblock);
		}
	}

	private function parse_docblock($docblock)
	{
		$docblock = trim($docblock, '/\\');
		foreach (explode_multiple(array("\n", "\r\n", "\r"), $docblock) as $line) {
			$line = trim($line, "\* \t");
			if (empty($line)) {
				continue;
			} else if (substr($line, 0, 1) === '@') {
				list($tagname) = explode_multiple(array(' ', "\t"), $line, 2);
				$tagvalue = substr($line, strlen($tagname));
				$tagvalue = trim($tagvalue, " \t"); 
				$tagname = substr($tagname, 1); // Remove the @
				$this->tags[$tagname] = $tagvalue;
				if ($tagname === 'package') {
					$this->package = $tagvalue;
				} else if ($tagname === 'uses') {
					foreach (explode(',', $tagvalue) as $dependency) {
						$this->dependencies[] = trim($dependency, " \t");
					}
				}
			} else if (empty($this->name)) {
				$this->name = $line;
			} else if (empty($this->description)) {
				$this->description = $line;
			} else {
				$this->description .= L . $line;
			}
		}
	}

	private function load_cache($cache)
	{
		$this->name = $cache['name'];
		$this->description = $cache['description'];
		$this->tags = $cache['tags'];
		$this->package = $cache['package'];
		$this->dependencies = $cache['dependencies'];
	}
	
	private function save_cache()
	{	
		$cache = get_option('harmony.module.cache');
		$cache[$this->slug] = array(
			'name' => $this->name,
			'description' => $this->description,
			'tags' => $this->tags,
			'package' => $this->package,
			'dependencies' => $this->dependencies,
			'time' => time()
		);

		update_option('harmony.module.cache', $cache);
	}

}