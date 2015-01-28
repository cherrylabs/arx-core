<?php namespace Arx\classes;

/**
 * Bag class
 *
 * Override the default array undefined behavior by returning smartly a false when a variable is not defined.
 *
 * It handle only 1 level
 *
 * @example :
 *
 * $bag = new Bag(array('title', 'array' => 'array value'))
 *
 * print $bag['falsevar'] ?: 'title by default';
 *
 */

class Bag implements \ArrayAccess, \Iterator {

	# Variables container

    public $__var;

	# Define if the bag is recursive or not

	protected $recursive = false;

	/**
	 * Construct a Variables Bag
	 *
	 * @param array $data
	 * @param bool $recursive
	 */
    public function __construct($data = array(), $recursive = false) {

	    if ( $recursive ) {
		    $this->recursive = true;
	    }

        $this->__var = $data;

        return $data;
    }

	/**
	 * Get params for Bag Object
	 *
	 * @param $key
	 *
	 * @return Bag|bool
	 */
    public function __get($key){

        if(is_object($this->__var) && isset($this->__var->{$key})){
            return $this->recursive ? new self($this->__var->{$key}, true) : $this->__var->{$key};
        }

        return false;
    }

	/**
	 * Set Equivalent for Object type
	 *
	 * @param $key
	 * @param $value
	 */
    public function __set($key, $value){
	    $this->__var->{$key} = $value;
    }

	/**
	 * Force the object/array to be returned as a string
	 *
	 * @return string
	 */
    public function __toString()
    {
        return (string) $this->__var;
    }

	/**
	 * Rewind method for the array
	 */
    public function rewind()
    {
        reset($this->__var);
    }

	/**
	 * Set the current index
	 *
	 * @return mixed
	 */
    public function current()
    {
        $var = current($this->__var);
        return $var;
    }

	/**
	 * Key handler for Array type
	 *
	 * @return mixed
	 */
    public function key()
    {
        $var = key($this->__var);
        return $var;
    }

	/**
	 * Next handler
	 *
	 * @return mixed|void
	 */
    public function next()
    {
        $var = next($this->__var);
        return $var;
    }

	/**
	 * Check if a bag value is valid
	 *
	 * @return bool
	 */
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
	        return $this->recursive ? new self($this->__var[$key], true) : $this->__var[$key];
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