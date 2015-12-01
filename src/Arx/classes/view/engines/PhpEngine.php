<?php namespace Arx\classes\view\engines;

use Arx\classes\Bag;
use Arx\classes\Debug;
use Illuminate\View\Engines;
use Illuminate\View\Engines\EngineInterface;

/**
 * Class PhpEngine
 * @package Arx\classes\view\engines
 */
class PhpEngine implements EngineInterface {

    protected $_data = array();

    public function __get($name){

        if(isset($this->_data[$name])){
            return $this->_data[$name];
        }

        return false;
    }

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : false;
    }

    public function __unset($name)
    {
        if(isset($this->_data[$name])) {
            unset($this->data[$name]);
        }
    }

    /**
     * Help debug method
     */
    public function help($level = null)
    {
        $vars = $this->_data->__var;

        unset($vars['__env']);
        unset($vars['app']);

        if($level)
            Debug::level($level);

        ddd($vars);
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = array())
    {
        return $this->evaluatePath($path, $data);
    }

    /**
     * Get the evaluated contents of the view at the given path.
     *
     * @param  string  $__path
     * @param  array   $__data
     * @return string
     */
    protected function evaluatePath($__path, $__data)
    {
        ob_start();

        extract($__data);

        $this->bag($__data);

        // We'll evaluate the contents of the view inside a try/catch block so we can
        // flush out any stray output that might get out before an error occurs or
        // an exception is thrown. This prevents any partial views from leaking.
        try
        {
            include $__path;
        }
        catch (\Exception $e)
        {
            $this->handleViewException($e);
        }

        return ob_get_clean();
    }

    /**
     * Transform Data variable to a Bag object
     *
     * @param $data
     */
    protected function bag($data){
        $this->_data = new Bag($data);
    }

    /**
     * Handle a view exception.
     *
     * @param  Exception $e
     * @throws Exception
     */
    protected function handleViewException($e)
    {
        ob_get_clean(); throw $e;
    }

}