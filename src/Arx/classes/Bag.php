<?php namespace Arx\classes;

/**
 * Bag class
 *
 * Override the default undefined behavior by returning smartly a false when a subvariable is not defined
 *
 * @example :
 *
 * $bag = new Bag(array('title', 'array' => 'array value'))
 *
 * print $bag['falsevar'] ?: 'title by default';
 *
 */

use Closure;

class Bag implements \ArrayAccess, \Iterator {

    private $__var = array();

    /**
     * Auto constructor
     * @param $data
     */
    public function __construct($data) {
        $this->__var = $data;
        return $data;
    }

    public function __get($key){
        if(is_object($this->__var) && isset($this->__var->{$key})){
            return new self($this->__var->{$key});
        }

        return false;
    }

    public function __set($key, $value){

    }

    public function __toString()
    {
        return $this->__var;
    }


    public function rewind()
    {
        reset($this->__var);
    }

    public function current()
    {
        $var = current($this->__var);
        return $var;
    }

    public function key()
    {
        $var = key($this->__var);
        return $var;
    }

    public function next()
    {
        $var = next($this->__var);
        return $var;
    }

    public function valid()
    {
        $key = key($this->__var);
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
        if(isset($this->__var[$key])){
            return new self($this->__var[$key]);
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

        if(is_array($this->__var) && isset($this->__var[$key])){
            return new self($this->__var[$key]);
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
        $this->__var[$key] = $value;
    }

    /**
     * Unset the value at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->__var[$key]);
    }
}