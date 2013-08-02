<?php namespace Arx\classes;

class Composer extends Container
{

    public function __construct()
    {
        $reflector = new \ReflectionClass("\\Composer\\Autoload\\ClassLoader");
        $this->path = dirname($reflector->getFileName());
    }

    public static function getPath()
    {
        $t = self::getInstance();
        return $t->path;
    }

    public static function getVendorPath()
    {
        $t = self::getInstance();
        return dirname($t->path);
    }

    public static function getRootPath()
    {
        $t = self::getInstance();
        return dirname(dirname($t->path));
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

        $flip = true;

        if($flip){
            return $response;
        } else {
            return $response;
        }
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