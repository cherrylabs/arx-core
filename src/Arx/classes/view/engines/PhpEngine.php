<?php namespace Arx\classes\view\engines;

use Arx\classes\Bag;
use Arx\classes\Debug;

/**
 * Class PhpEngine
 * @package Arx\classes\view\engines
 */
class PhpEngine extends \Illuminate\View\Engines\PhpEngine {

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
     * Transform Data variable to a Bag object
     *
     * @param $data
     */
    protected function bag($data){
        $this->_data = new Bag($data);
    }

}