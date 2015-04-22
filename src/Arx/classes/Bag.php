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

    public function __isset($key)
    {
        return isset($this->__var->{$key}) ? $this->__var->{$key} : false;
    }

    public function __unset($key)
    {
        if(isset($this->__var[$key])) {
            unset($this->__var[$key]);
        }
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

    /**
     * Returns the parameters.
     *
     * @return array An array of parameters
     *
     * @api
     */
    public function all()
    {
        return $this->__var;
    }

    /**
     * Returns the parameter keys.
     *
     * @return array An array of parameter keys
     *
     * @api
     */
    public function keys()
    {
        return array_keys($this->__var);
    }

    /**
     * Replaces the current parameters by a new set.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
    public function replace(array $parameters = array())
    {
        $this->__var = $parameters;
    }

    /**
     * Adds parameters.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
    public function add(array $parameters = array())
    {
        $this->__var = array_replace($this->__var, $parameters);
    }

    /**
     * Returns a parameter by name.
     *
     * @param string $path    The key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     *
     * @api
     */
    public function get($path, $default = null, $deep = false)
    {
        if (!$deep || false === $pos = strpos($path, '[')) {
            return array_key_exists($path, $this->__var) ? $this->__var[$path] : $default;
        }

        $root = substr($path, 0, $pos);
        if (!array_key_exists($root, $this->__var)) {
            return $default;
        }

        $value = $this->__var[$root];
        $currentKey = null;
        for ($i = $pos, $c = strlen($path); $i < $c; $i++) {
            $char = $path[$i];

            if ('[' === $char) {
                if (null !== $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "[" at position %d.', $i));
                }

                $currentKey = '';
            } elseif (']' === $char) {
                if (null === $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "]" at position %d.', $i));
                }

                if (!is_array($value) || !array_key_exists($currentKey, $value)) {
                    return $default;
                }

                $value = $value[$currentKey];
                $currentKey = null;
            } else {
                if (null === $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "%s" at position %d.', $char, $i));
                }

                $currentKey .= $char;
            }
        }

        if (null !== $currentKey) {
            throw new \InvalidArgumentException(sprintf('Malformed path. Path must end with "]".'));
        }

        return $value;
    }

    /**
     * Sets a parameter by name.
     *
     * @param string $key   The key
     * @param mixed  $value The value
     *
     * @api
     */
    public function set($key, $value)
    {
        $this->__var[$key] = $value;
    }

    /**
     * Returns true if the parameter is defined.
     *
     * @param string $key The key
     *
     * @return bool true if the parameter exists, false otherwise
     *
     * @api
     */
    public function has($key)
    {
        return array_key_exists($key, $this->__var);
    }

    /**
     * Removes a parameter.
     *
     * @param string $key The key
     *
     * @api
     */
    public function remove($key)
    {
        unset($this->__var[$key]);
    }

    /**
     * Returns the alphabetic characters of the parameter value.
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return string The filtered value
     *
     * @api
     */
    public function getAlpha($key, $default = '', $deep = false)
    {
        return preg_replace('/[^[:alpha:]]/', '', $this->get($key, $default, $deep));
    }

    /**
     * Returns the alphabetic characters and digits of the parameter value.
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return string The filtered value
     *
     * @api
     */
    public function getAlnum($key, $default = '', $deep = false)
    {
        return preg_replace('/[^[:alnum:]]/', '', $this->get($key, $default, $deep));
    }

    /**
     * Returns the digits of the parameter value.
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return string The filtered value
     *
     * @api
     */
    public function getDigits($key, $default = '', $deep = false)
    {
        // we need to remove - and + because they're allowed in the filter
        return str_replace(array('-', '+'), '', $this->filter($key, $default, $deep, FILTER_SANITIZE_NUMBER_INT));
    }

    /**
     * Returns the parameter value converted to integer.
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return int The filtered value
     *
     * @api
     */
    public function getInt($key, $default = 0, $deep = false)
    {
        return (int) $this->get($key, $default, $deep);
    }

    /**
     * Returns the parameter value converted to boolean.
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return bool The filtered value
     */
    public function getBoolean($key, $default = false, $deep = false)
    {
        return $this->filter($key, $default, $deep, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Filter key.
     *
     * @param string $key     Key.
     * @param mixed  $default Default = null.
     * @param bool   $deep    Default = false.
     * @param int    $filter  FILTER_* constant.
     * @param mixed  $options Filter options.
     *
     * @see http://php.net/manual/en/function.filter-var.php
     *
     * @return mixed
     */
    public function filter($key, $default = null, $deep = false, $filter = FILTER_DEFAULT, $options = array())
    {
        $value = $this->get($key, $default, $deep);

        // Always turn $options into an array - this allows filter_var option shortcuts.
        if (!is_array($options) && $options) {
            $options = array('flags' => $options);
        }

        // Add a convenience check for arrays.
        if (is_array($value) && !isset($options['flags'])) {
            $options['flags'] = FILTER_REQUIRE_ARRAY;
        }

        return filter_var($value, $filter, $options);
    }

    /**
     * Returns an iterator for parameters.
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->__var);
    }

    /**
     * Returns the number of parameters.
     *
     * @return int The number of parameters
     */
    public function count()
    {
        return count($this->__var);
    }
}