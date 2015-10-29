<?php namespace Arx\classes;
/**
 * Class ClassLoader
 *
 * Loads your project classes automatically if they follow some standard PHP conventions.
 *
 * @compatibility php
 * @see : http://symfony.com/fr/doc/current/components/class_loader.html
 * @package Arx\classes
 */
class ClassLoader
{
    private $namespaces = array();
    private $prefixes = array();
    private $namespaceFallbacks = array();
    private $prefixFallbacks = array();
    private $useIncludePath = false;


    /**
     * The registered directories.
     *
     * @var array
     */
    protected static $directories = array();

    /**
     * Indicates if a ClassLoader has been registered.
     *
     * @var bool
     */
    protected static $registered = false;

    /**
     * Load the given class file.
     *
     * @param  string  $class
     * @return bool
     */
    public static function load($class)
    {
        $class = static::normalizeClass($class);

        foreach (static::$directories as $directory)
        {
            if (file_exists($path = $directory.DIRECTORY_SEPARATOR.$class))
            {
                require_once $path;

                return true;
            }
        }
        return false;
    }

    /**
     * Get the normal file name for a class.
     *
     * @param  string  $class
     * @return string
     */
    public static function normalizeClass($class)
    {
        if ($class[0] == '\\') $class = substr($class, 1);

        return str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $class).'.php';
    }

    /**
     * Register the given class loader on the auto-loader stack.
     *
     * @return void
     */
    public static function register()
    {
        if ( ! static::$registered)
        {
            static::$registered = spl_autoload_register(array('\Arx\classes\ClassLoader', 'load'));
        }
    }

    /**
     * Add directories to the class loader.
     *
     * @param  string|array  $directories
     * @return void
     */
    public static function addDirectories($directories)
    {
        static::$directories = array_merge(static::$directories, (array) $directories);

        static::$directories = array_unique(static::$directories);
    }

    /**
     * Remove directories from the class loader.
     *
     * @param  string|array  $directories
     * @return void
     */
    public static function removeDirectories($directories = null)
    {
        if (is_null($directories))
        {
            static::$directories = array();
        }
        else
        {
            $directories = (array) $directories;

            static::$directories = array_filter(static::$directories, function($directory) use ($directories)
            {
                return ( ! in_array($directory, $directories));
            });
        }
    }

    /**
     * Gets all the directories registered with the loader.
     *
     * @return array
     */
    public static function getDirectories()
    {
        return static::$directories;
    }

    /**
     * Turns on searching the include for class files. Allows easy loading
     * of installed PEAR packages
     *
     * @param Boolean $useIncludePath
     */
    public function useIncludePath($useIncludePath)
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
     * Gets the configured namespaces.
     *
     * @return array A hash with namespaces as keys and directories as values
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * Gets the configured class prefixes.
     *
     * @return array A hash with class prefixes as keys and directories as values
     */
    public function getPrefixes()
    {
        return $this->prefixes;
    }

    /**
     * Gets the directory(ies) to use as a fallback for namespaces.
     *
     * @return array An array of directories
     */
    public function getNamespaceFallbacks()
    {
        return $this->namespaceFallbacks;
    }

    /**
     * Gets the directory(ies) to use as a fallback for class prefixes.
     *
     * @return array An array of directories
     */
    public function getPrefixFallbacks()
    {
        return $this->prefixFallbacks;
    }

    /**
     * Registers the directory to use as a fallback for namespaces.
     *
     * @param array $dirs An array of directories
     *
     * @api
     */
    public function registerNamespaceFallbacks(array $dirs)
    {
        $this->namespaceFallbacks = $dirs;
    }

    /**
     * Registers a directory to use as a fallback for namespaces.
     *
     * @param string $dir A directory
     */
    public function registerNamespaceFallback($dir)
    {
        $this->namespaceFallbacks[] = $dir;
    }

    /**
     * Registers directories to use as a fallback for class prefixes.
     *
     * @param array $dirs An array of directories
     *
     * @api
     */
    public function registerPrefixFallbacks(array $dirs)
    {
        $this->prefixFallbacks = $dirs;
    }

    /**
     * Registers a directory to use as a fallback for class prefixes.
     *
     * @param string $dir A directory
     */
    public function registerPrefixFallback($dir)
    {
        $this->prefixFallbacks[] = $dir;
    }

    /**
     * Registers an array of namespaces
     *
     * @param array $namespaces An array of namespaces (namespaces as keys and locations as values)
     *
     * @api
     */
    public function registerNamespaces(array $namespaces)
    {
        foreach ($namespaces as $namespace => $locations) {
            $this->namespaces[$namespace] = (array) $locations;
        }
    }

    /**
     * Registers a namespace.
     *
     * @param string       $namespace The namespace
     * @param array|string $paths     The location(s) of the namespace
     *
     * @api
     */
    public function registerNamespace($namespace, $paths)
    {
        $this->namespaces[$namespace] = (array) $paths;
    }

    /**
     * Registers an array of classes using the PEAR naming convention.
     *
     * @param array $classes An array of classes (prefixes as keys and locations as values)
     *
     * @api
     */
    public function registerPrefixes(array $classes)
    {
        foreach ($classes as $prefix => $locations) {
            $this->prefixes[$prefix] = (array) $locations;
        }
    }

    /**
     * Registers a set of classes using the PEAR naming convention.
     *
     * @param string       $prefix The classes prefix
     * @param array|string $paths  The location(s) of the classes
     *
     * @api
     */
    public function registerPrefix($prefix, $paths)
    {
        $this->prefixes[$prefix] = (array) $paths;
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
            $namespace = substr($class, 0, $pos);
            $className = substr($class, $pos + 1);
            $normalizedClass = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
            foreach ($this->namespaces as $ns => $dirs) {
                if (0 !== strpos($namespace, $ns)) {
                    continue;
                }

                foreach ($dirs as $dir) {
                    $file = $dir.DIRECTORY_SEPARATOR.$normalizedClass;
                    if (is_file($file)) {
                        return $file;
                    }
                }
            }

            foreach ($this->namespaceFallbacks as $dir) {
                $file = $dir.DIRECTORY_SEPARATOR.$normalizedClass;
                if (is_file($file)) {
                    return $file;
                }
            }

        } else {
            // PEAR-like class name
            $normalizedClass = str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';
            foreach ($this->prefixes as $prefix => $dirs) {
                if (0 !== strpos($class, $prefix)) {
                    continue;
                }

                foreach ($dirs as $dir) {
                    $file = $dir.DIRECTORY_SEPARATOR.$normalizedClass;
                    if (is_file($file)) {
                        return $file;
                    }
                }
            }

            foreach ($this->prefixFallbacks as $dir) {
                $file = $dir.DIRECTORY_SEPARATOR.$normalizedClass;
                if (is_file($file)) {
                    return $file;
                }
            }
        }

        if ($this->useIncludePath && $file = stream_resolve_include_path($normalizedClass)) {
            return $file;
        }
    }
}