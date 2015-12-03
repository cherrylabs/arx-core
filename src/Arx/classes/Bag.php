<?php namespace Arx\classes;

/**
 * Bag class
 *
 * Override the default array undefined behavior by returning smartly a false when a variable is not defined.
 *
 * /!\ It handle only 1 level for now
 *
 * @example :
 *
 * $bag = new Bag(array('title', 'array' => 'array value'))
 *
 * print $bag['falsevar'] ?: 'title by default';
 *
 * print $bag->has('title');
 *
 * print $bag->get('title', 'default');
 */

class Bag implements \ArrayAccess, \Iterator {

	# Variables container

    public $data;

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

        $this->data = $data;

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

        if(is_object($this->data) && isset($this->data->{$key})){
            return $this->recursive ? new self($this->data->{$key}, true) : $this->data->{$key};
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
	    $this->data->{$key} = $value;
    }

    public function __isset($key)
    {
        return isset($this->data->{$key}) ? $this->data->{$key} : false;
    }

    public function __unset($key)
    {
        if(isset($this->data[$key])) {
            unset($this->data[$key]);
        }
    }

	/**
	 * Force the object/array to be returned as a string
	 *
	 * @return string
	 */
    public function __toString()
    {
        return (string) $this->data;
    }

    /**
     * Add a Get method (similar to Input::get)
     *
     * @example $bag->get('dada.dada');
     * @param $needle
     * @param null $default
     * @return mixed
     */
    public function get($needle, $default = null){
        return Arr::get($this->data, $needle, $default);
    }

    /**
     * Add a has method (similar to Input::has)
     *
     *
     * @example $bag->has('dada.dada');
     * @param $needle
     * @param null $default
     * @return bool
     */
    public function has($needle, $default = null){
        return Arr::get($this->data, $needle, $default) ? true : false;
    }

	/**
	 * Rewind method for the array
	 */
    public function rewind()
    {
        reset($this->data);
    }

	/**
	 * Set the current index
	 *
	 * @return mixed
	 */
    public function current()
    {
        $var = current($this->data);
        return $var;
    }

	/**
	 * Key handler for Array type
	 *
	 * @return mixed
	 */
    public function key()
    {
        $var = key($this->data);
        return $var;
    }

	/**
	 * Next handler
	 *
	 * @return mixed|void
	 */
    public function next()
    {
        $var = next($this->data);
        return $var;
    }

	/**
	 * Check if a bag value is valid
	 *
	 * @return bool
	 */
    public function valid()
    {
        $key = key($this->data);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    /**
     * Determine if a given offset exists
     *
     * /!\ different from has method
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        if(isset($this->data[$key])){
            return new self($this->data[$key]);
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

        if(is_array($this->data) && isset($this->data[$key])){
	        return $this->recursive ? new self($this->data[$key], true) : $this->data[$key];
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
        $this->data[$key] = $value;
    }

    /**
     * Unset the value at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }
}