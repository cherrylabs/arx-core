<?php namespace Arx\classes\view;

use Arx;
use Illuminate\View\FileViewFinder as ParentClass;
use Whoops\Example\Exception;



class FileViewFinder extends ParentClass
{

    protected $extensions = array('blade.php','tpl.php','tpl.js','mustache.php','twig.php', 'php');

    /**
     * Find a correct path file
     *
     * @param string $name
     *
     * @return string
     */
    public function find($name)
    {

        if (strpos($name, '::') !== false) {
            return $this->findNamedPathView($name);
        }
        return $this->findInPaths($name, $this->paths);
    }

    /**
     * Get the path to a template with a named path.
     *
     * @param  string  $name
     * @return string
     */
    protected function findNamedPathView($name)
    {
        list($namespace, $view) = $this->getNamespaceSegments($name);

        return $this->findInPaths($view, $this->hints[$namespace]);
    }

    /**
     * Get the segments of a template with a named path.
     *
     * @param  string  $name
     * @return array
     */
    protected function getNamespaceSegments($name)
    {
        $segments = explode('::', $name);

        if (count($segments) != 2)
        {
            throw new \InvalidArgumentException("View [$name] has an invalid name.");
        }

        if ( ! isset($this->hints[$segments[0]]))
        {
            throw new \InvalidArgumentException("No hint path defined for [{$segments[0]}].");
        }

        return $segments;
    }

    /**
     * Find the given view in the list of paths.
     *
     * @param  string  $name
     * @param  array   $paths
     * @return string
     */
    protected function findInPaths($name, $paths)
    {
        if(preg_match('/arx/i', $name)){
            foreach ($this->getPossibleViewFiles($name) as $file)
            {
                if ($this->files->exists($viewPath = str_replace('arx/', Arx::getPath('views').'/', $file)))
                {
                    return $viewPath;
                }
            }
        }


        foreach ((array) $paths as $path)
        {
            foreach ($this->getPossibleViewFiles($name) as $file)
            {
                if ($this->files->exists($viewPath = $path.'/'.$file))
                {
                    return $viewPath;
                }
            }
        }

        # Last chance to have a file, check if is file and not in Public
        if(preg_match('/\//', $name) && is_file($name)){
            return $name;
        }

        throw new \InvalidArgumentException("View [$name] not found.");
    }

    /**
     * Get an array of possible view files.
     *
     * @param  string  $name
     * @return array
     */
    protected function getPossibleViewFiles($name)
    {
        if(is_file($name)){
            return array($name);
        }

        $response = array_map(function($extension) use ($name)
        {
            return str_replace('.', '/', $name).'.'.$extension;

        }, $this->extensions);

        return $response;
    }

}