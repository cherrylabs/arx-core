<?php namespace Arx\classes;
/**
 * Class Composer
 *
 * Helps to resolve and find Composer paths
 *
 * @compatibility php
 * @package Arx\classes
 */
class Composer extends Container
{

    public function __construct()
    {
        $reflector = new \ReflectionClass("\\Composer\\Autoload\\ClassLoader");
        $this->path = dirname($reflector->getFileName());
    }

    /**
     * Get path of used vendors
     */
    public static function getPath($vendorPath = null)
    {
        $t = self::getInstance();
        return $t->path.$vendorPath;
    }

    public static function getVendorPath($path = null)
    {
        $t = self::getInstance();
        return dirname($t->path).$path;
    }

    public static function getRootPath($path = null)
    {
        $t = self::getInstance();

        return dirname(dirname($t->path)).$path;
    }

    public static function resolvePath($path){
        if(!preg_match('/^\//i', $path)){
            $path = '/'.$path;
        }
        return $path;
    }

    /**
     * Get the array of namespace defined in composer
     *
     * It includes a array_flip function to add a more easy way to handle the array
     *
     * @param null $flip
     *
     * @return array|mixed
     */
    public static function getNamespaces($flip = null)
    {
        $t = self::getInstance();
        $response = (array) include $t->path . DS . 'autoload_namespaces.php';

        if($flip){
            return array_flip($response);
        } else {
            return $response;
        }
    }

    /**
     * Get the array of namespace defined in composer
     *
     * It includes a array_flip function to add a more easy way to handle the array
     *
     * @param null $flip
     *
     * @return array|mixed
     */
    public static function getNamespacesPSR4($flip = null)
    {
        $t = self::getInstance();
        $response = (array) include $t->path . DS . 'autoload_psr4.php';

        if($flip){
            return array_flip($response);
        } else {
            return $response;
        }
    }

    public static function getPathByNamespace($namespace){
        $namespaces = self::getNamespaces();

        if(isset($namespaces[$namespace])){
            return $namespaces[$namespace][0].'/'.$namespace;
        }

        return false;
    }

    public static function getClassmap()
    {
        $t = self::getInstance();
        return include $t->path . DS . 'autoload_classmap.php';
    }

    public static function getIncludedPaths()
    {
        $t = self::getInstance();
        return include $t->path . DS . 'include_paths.php';
    }

}