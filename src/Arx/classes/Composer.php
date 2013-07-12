<?php namespace Arx\classes;

class Composer extends Container{

    public function __construct(){
        $reflector = new \ReflectionClass("\\Composer\\Autoload\\ClassLoader");
        $this->path = dirname($reflector->getFileName());
    }

    public static function getPath() {
        $t = self::getInstance();
        return $t->path;
    }

    public static function getNamespaces(){
        $t = self::getInstance();
        return include $t->path . DS . 'autoload_namespaces.php';
    }

    public static function getClassmap(){
        $t = self::getInstance();
        return include $t->path . DS . 'autoload_classmap.php';
    }

    public static function getIncludedPaths(){
        $t = self::getInstance();
        return include $t->path . DS . 'include_paths.php';
    }

}