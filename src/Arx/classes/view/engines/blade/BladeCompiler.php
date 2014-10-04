<?php namespace Arx\classes\view\engines\blade;

use Closure;
use Illuminate\Filesystem\Filesystem;

use Illuminate\View\Compilers\BladeCompiler as ParentClass;

/**
 * Class BladeCompiler
 *
 * Extend BladeCompiler
 *
 * @see Illuminate\View\Compilers\BladeCompiler
 * @package Arx\classes\view\engines\blade
 */
class BladeCompiler extends ParentClass {

    /**
     * All of the registered extensions.
     *
     * @var array
     */
    protected $extensions = array();

}