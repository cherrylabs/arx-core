<?php namespace Arx\classes\view;

use Illuminate\View\FileViewFinder as ParentClass;
use Whoops\Example\Exception;

class FileViewFinder extends ParentClass
{

    protected $extensions = array('blade.php', 'php','tmpl.php','mustache.php','twig.php');

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
     * Find the given view in the list of paths.
     *
     * @param  string  $name
     * @param  array   $paths
     * @return string
     */
    protected function findInPaths($name, $paths)
    {
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