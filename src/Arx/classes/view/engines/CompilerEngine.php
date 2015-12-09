<?php namespace Arx\classes\view\engines;

use Arx\classes\Arr;
use Illuminate\View\Engines\CompilerEngine as ParentClass;
use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\View\EngineInterface;

/**
 * Class CompilerEngine
 * @package Arx\classes\view\engines
 */
class CompilerEngine extends PhpEngine {

    /**
     * The Blade compiler instance.
     *
     * @var \Illuminate\View\Compilers\CompilerInterface
     */
    protected $compiler;

    /**
     * Create a new Blade view engine instance.
     *
     * @param  \Illuminate\View\Compilers\CompilerInterface $compiler
     */
    public function __construct(CompilerInterface $compiler)
    {
        $this->compiler = $compiler;
    }

    public function angularApp($ngApp){
        $this->ngApp = $ngApp;
    }

    public function angularCtrl($ngCtrl){
        $this->ngCtrl = $ngCtrl;
    }

    public function bodyAttributes($attr, $value = null){

        if (!isset($this->body['attributes'])) {
            $this->body['attributes'] = array();
        }

        $body = $this->body;

        if (is_array($attr)) {
            foreach ($attr as $k => $value) {
                $body['attributes'][$k] = $value;
            }
        } else {
            $body['attributes'][$attr] = $value;
        }

        $this->body = $body;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param  \Illuminate\View\Environment  $environment
     * @param  string  $view
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = array())
    {
        // If this given view has expired, which means it has simply been edited since
        // it was last compiled, we will re-compile the views so we can evaluate a
        // fresh copy of the view. We'll pass the compiler the path of the view.
        if ($this->compiler->isExpired($path))
        {
            $this->compiler->compile($path);
        }

        # SAVE VIEWS INFO IN SERVER DATA
        $_SERVER['view_used'] = realpath($path);

        $compiled = $this->compiler->getCompiledPath($path);

        return $this->evaluatePath($compiled, $data);
    }

    /**
     * Get the compiler implementation.
     *
     * @return \Illuminate\View\Compilers\CompilerInterface
     */
    public function getCompiler()
    {
        return $this->compiler;
    }

    /**
     * Get the compiler implementation.
     *
     * @return \Illuminate\View\Compilers\CompilerInterface
     */
    public function hook($data, $params = array())
    {
        $aDefParams = array('function' => 'array_merge_recursive');

        $params = array_merge_recursive($aDefParams, $params);

        if(is_array($this->_data->__var)){
            $this->_data->__var = call_user_func($params['function'], $this->_data->__var, $data);
        }

        return $this->_data->__var;
    }

    public function toArray()
    {
        $toArray = json_decode(json_encode($this->_data->data), true);

        unset($toArray['__env']);
        unset($toArray['app']);

        return $toArray;
    }
}