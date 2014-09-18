<?php namespace Arx\classes;

/**
 * Bag class
 *
 * Override the default undefined behavior by returning smartly a false when a variable is not defined
 *
 * @example :
 *
 * $bag = new Bag(array('title', 'array' => 'array value'))
 *
 * print $bag['falsevar'] or 'title by default';
 *
 */

class Bag implements \ArrayAccess, \Iterator {

    public $_var = array();

    /**
     * Auto constructor
     * @param $data
     */
    public function __construct(array $data = array()) {
        $this->_var = $data;
        return $data;
    }

    public function __get($key){

        if(is_object($this->_var) && isset($this->_var->{$key})){
            return new self($this->_var->{$key});
        }

        return false;
    }

    public function __set($key, $value){
        $this->_var[$key] = $value;
    }

    public function rewind()
    {
        reset($this->_var);
    }

    public function current()
    {
        $var = current($this->_var);
        return $var;
    }

    public function key()
    {
        $var = key($this->_var);
        return $var;
    }

    public function next()
    {
        $var = next($this->_var);
        return $var;
    }

    public function valid()
    {
        $key = key($this->_var);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    /**
     * Determine if a given offset exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        if(isset($this->_var[$key])){
            return new self($this->_var[$key]);
        }

        return false;
    }

    /**
     * Get the value at a given offset.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {

        if(is_array($this->_var) && isset($this->_var[$key])){
            return $this->_var[$key];
        }

        return false;
    }

    /**
     * Set the value at a given offset.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->_var[$key] = $value;
    }

    /**
     * Unset the value at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->_var[$key]);
    }
}