<?php

/**
 * Harmony PSR-0 Autoloader
 *
 * Total ripoff of https://github.com/symfony/ClassLoader/blob/2.4/ClassLoader.php
 * with a few tweaks to make it consistant with the psr-4 autoloader 
 * 
 * @author Simon Holloway
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class Harmony_PSR0_Autoloader
{
    private $namespaces = array();
    private $fallbackDirs = array();
    private $useIncludePath = false;

    /**
     * Registers this instance as an autoloader.
     *
     * @param Boolean $prepend Whether to prepend the autoloader or not
     */
    public function register($prepend = false)
    {
        spl_autoload_register(array($this, 'loadClass'), true, $prepend);
    }

    /**
     * Unregisters this instance as an autoloader.
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     * Returns namespaces.
     *
     * @return array
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * Returns fallback directories.
     *
     * @return array
     */
    public function getFallbackDirs()
    {
        return $this->fallbackDirs;
    }

    /**
     * Adds namespaces.
     *
     * @param array $namespaces namespaces to add
     */
    public function addNamespaces(array $namespaces)
    {
        foreach ($namespaces as $namespace => $path) {
            $this->addNamespace($namespace, $path);
        }
    }

    /**
     * Registers a set of classes
     *
     * @param string       $namespace The classes namespace
     * @param array|string $paths  The location(s) of the classes
     */
    public function addNamespace($namespace, $paths)
    {
        if (!$namespace) {
            foreach ((array) $paths as $path) {
                $this->fallbackDirs[] = $path;
            }

            return;
        }
        if (isset($this->namespaces[$namespace])) {
            $this->namespaces[$namespace] = array_merge(
                $this->namespaces[$namespace],
                (array) $paths
            );
        } else {
            $this->namespaces[$namespace] = (array) $paths;
        }
    }

    /**
     * Turns on searching the include for class files.
     *
     * @param Boolean $useIncludePath
     */
    public function setUseIncludePath($useIncludePath)
    {
        $this->useIncludePath = $useIncludePath;
    }

    /**
     * Can be used to check if the autoloader uses the include path to check
     * for classes.
     *
     * @return Boolean
     */
    public function getUseIncludePath()
    {
        return $this->useIncludePath;
    }

    /**
     * Loads the given class or interface.
     *
     * @param string $class The name of the class
     *
     * @return Boolean|null True, if loaded
     */
    public function loadClass($class)
    {
        if ($file = $this->findFile($class)) {
            require $file;

            return true;
        }
    }

    /**
     * Finds the path to the file where the class is defined.
     *
     * @param string $class The name of the class
     *
     * @return string|null The path, if found
     */
    public function findFile($class)
    {
        if (false !== $pos = strrpos($class, '\\')) {
            // namespaced class name
            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 0, $pos)).DIRECTORY_SEPARATOR;
            $className = substr($class, $pos + 1);
        } else {
            // PEAR-like class name
            $classPath = null;
            $className = $class;
        }

        $classPath .= str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';

        foreach ($this->namespaces as $namespace => $dirs) {
            if ($class === strstr($class, $namespace)) {
                foreach ($dirs as $dir) {
                    if (file_exists($dir.DIRECTORY_SEPARATOR.$classPath)) {
                        return $dir.DIRECTORY_SEPARATOR.$classPath;
                    }
                }
            }
        }

        foreach ($this->fallbackDirs as $dir) {
            if (file_exists($dir.DIRECTORY_SEPARATOR.$classPath)) {
                return $dir.DIRECTORY_SEPARATOR.$classPath;
            }
        }

        if ($this->useIncludePath && $file = stream_resolve_include_path($classPath)) {
            return $file;
        }
    }
}