<?php namespace Arx\classes;

use ReflectionMethod;

/**
 * Array Class with more features
 *
 * You can use it as stand-alone in any Php Project
 *
 * @category Utils
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Arr
 */
class Arr
{

#A
    /**
     * Array_assign_key assign the key
     *
     * @param $arr
     * @param string $sKeyOrArray
     * @return array
     * @internal param mixed $data
     */
    public static function array_assign_subkey($arr, $sKeyOrArray = 'id')
    {
        $aNew = array();

        //default option
        $c = array(
            "old_key" => "_key"
        );

        if (is_string($sKeyOrArray)) {
            $c['key'] = $sKeyOrArray;
        } elseif (is_array($sKeyOrArray)) {
            $c = array_merge($c, $sKeyOrArray);
        }

        foreach ($arr as $key => $v) {
            if (is_object($v)) {
                if (isset($v->$c['key'])) {
                    if (!isset($c['delete_old_key'])) $v->{$c['old_key']} = $key;
                    $aNew[$v->{$c['key']}] = $v;
                }
            } elseif (is_array($v)) {
                if (isset($v[$c['key']])) {
                    if (!isset($c['delete_old_key'])) $v[$c['old_key']] = $key;

                    $aNew[$v[$c['key']]] = $v;
                }
            }
        }

        return $aNew;
    }


    /**
     * Divide array into multilple
     * @param  array $array array to divide
     * @param  integer $nb nb of array to return
     * @param  boolean $preserve_key preserve key or not
     * @return array                Arr splitted
     */
    public static function array_divide($array, $nb = 2, $preserve_key = true)
    {
        $iMiddle = round(count($array) / $nb, 0, PHP_ROUND_HALF_UP);
        return array_chunk($array, $iMiddle, $preserve_key);
    }


    /**
     * Diverse array with a specific value
     *
     * @param  [type] $array [description]
     * @return array [type]        [description]
     */
    public static function array_diverse($array)
    {
        $result = array();

        foreach ($array as $key1 => $value1) {
            if (is_array($value1)) {
                foreach ($value1 as $key2 => $value2) {
                    $result[$key2][$key1] = $value2;
                }
            } else {
                $result[0][$key1] = $value1;
            }
        }

        return $result;
    }

    /**
     * array_filter_keys
     *
     * return an array of key
     *
     * @param      $array with = regExp to match
     * @param null $params
     * @return array
     * @internal param null $c
     *
     */
    public static function array_filter_keys($array, $params = null)
    {

        $array = self::toArray($array);

        $isMultidimensionnal = self::is_multi($array);

        if (is_string($params)) {
            $params = array('with' => $params);
        }

        if (isset($params['with'])) {
            $data = array();

            if (!$isMultidimensionnal) {
                foreach ($array as $key => $value) {
                    if (preg_match('/' . $params['with'] . '/i', $key)) {
                        $data[] = $value;
                    }
                }
            } else {
                foreach ($array as $v1) {
                    foreach ($v1 as $key => $value) {
                        if (preg_match('/' . $params['with'] . '/i', $key)) {
                            $data[] = $value;
                        }
                    }
                }
            }

            return $data;
        }

        return array_filter($array);

    }

    /**
     * Array filters with particular values
     *
     * @example
     *
     * array_filter_values(["test","dada"], "te")
     * => will return only test
     *
     * @param $array
     * @param array $params
     * @return array
     * @internal param null $c
     */
    public static function array_filter_values($array, $params = [])
    {
        if (is_string($params)) {
            $params = array('with' => $params);
        }

        if (isset($params['with'])) {

            $data = array();

            foreach ($array as $key => $value) {
                if (preg_match('/' . $params['with'] . '/i', $value)) {
                    $data[$key] = $value;
                }
            }

            return $data;
        } else {
            return array_filter($array);
        }
    }

    /**
     * return the next element of a specific key
     *
     * @param $arr
     * @param $nested_key
     * @param int $iteration
     * @internal param $ $
     *
     * @return bool|mixed
    @code
     *
     * @endcode
     */
    public static function array_next_element($arr, $nested_key, $iteration = 1)
    {
        foreach ($arr as $key => $v) {
            current($arr);

            if ($key == $nested_key) {
                for ($i = 0; $i < $iteration; $i++) {
                    $return = next($arr);
                }

                if (!empty($return)) {
                    return $return;
                } else {
                    return false;
                }
            }

            next($arr);
        }

        return false;
    }

    /**
     * return the prev element of a specific key
     *
     * @param $arr
     * @param $nested_key
     * @param int $iteration
     * @return bool|mixed
     */
    public static function array_prev_element($arr, $nested_key, $iteration = 1)
    {
        foreach ($arr as $key => $v) {
            if ($key == $nested_key) {
                for ($i = 0; $i < $iteration; $i++) {
                    $return = prev($arr);
                }

                if (!empty($return)) {
                    return $return;
                } else {
                    return false;
                }
            }

            next($arr);
        }

        return false;
    }

    public static function array_to_dot($key)
    {
        return str_replace(array('][', '[', ']'), array('.', '.', ''), $key);
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array $array
     * @param  string $key
     * @param  mixed $value
     * @return array
     */
    public static function array_set(&$array, $key, $value)
    {
        if (is_null($key)) return $array = $value;

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = array();
            }

            $array =& $array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    /**
     * Transform an array into a csv
     *
     * @param $array
     * @param null $downloadFile if download is set => will output directly the csv
     * @return string
     */
    public static function arrayToCSV($array, $downloadFile = null)
    {

        if ($downloadFile) {
            header('Content-Type: application/csv');
            header('Content-Disposition: attachement; filename="' . $downloadFile . '"');
        }

        ob_start();
        $f = fopen('php://output', 'w') or ("Can't open php://output");
        $n = 0;
        foreach ($array as $line) {
            $n++;
            if (!fputcsv($f, $line)) {
                ("Can't write line $n: $line");
            }
        }
        fclose($f) or ("Can't close php://output");
        $str = ob_get_contents();
        ob_end_clean();

        if (!$downloadFile) {
            return $str;
        }

        echo $str;
    }


    /**
     * Converts a multi-dimensional associative array into an array of key => values with the provided field names
     *
     * @param   array $assoc the array to convert
     * @param   string $key_field the field name of the key field
     * @param   string $val_field the field name of the value field
     * @return  array
     * @throws  \InvalidArgumentException
     */
    public static function assocToKeyval($assoc, $key_field, $val_field)
    {
        if (!is_array($assoc) and !$assoc instanceof \Iterator) {
            throw new \InvalidArgumentException('The first parameter must be an array.');
        }

        $output = array();
        foreach ($assoc as $row) {
            if (isset($row[$key_field]) and isset($row[$val_field])) {
                $output[$row[$key_field]] = $row[$val_field];
            }
        }

        return $output;
    }

    /**
     * Find the average of an array
     *
     * @param the $array
     * @internal param \Arx\classes\the $array array containing the values
     * @return  numeric  the average value
     */
    public static function average($array)
    {
        // No arguments passed, lets not divide by 0
        if (!($count = count($array)) > 0) {
            return 0;
        }

        return (array_sum($array) / $count);
    }

#B

#C

    /**
     * Converts the given 1 dimensional non-associative array to an associative
     * array.
     *
     * The array given must have an even number of elements or null will be returned.
     *
     *     Arr::to_assoc(array('foo','bar'));
     *
     * @param   string $arr the array to change
     * @return  array|null  the new array or null
     * @throws  \BadMethodCallException
     */
    public static function convert(array $arr)
    {
        if (($count = count($arr)) % 2 > 0) {
            throw new \BadMethodCallException('Number of values in to_assoc must be even.');
        }
        $keys = $vals = array();

        for ($i = 0; $i < $count - 1; $i += 2) {
            $keys[] = array_shift($arr);
            $vals[] = array_shift($arr);
        }
        return array_combine($keys, $vals);
    }

    /**
     * Transform a CSV file to array
     *
     * @param $file
     * @param array $param
     * @return array
     */
    public static function csvToArray($file, $param = array(
        'length' => 0,
        'delimiter' => ';',
        'enclosure' => '"',
        'escape' => '\\',
        'skipFirstRow' => false,
        'indexFromFirstRow' => false
    ))
    {

        $defParam = array(
            'length' => 0,
            'delimiter' => ';',
            'enclosure' => '"',
            'escape' => '\\',
            'skipFirstRow' => false,
            'indexFromFirstRow' => false
        );

        $param = array_merge($defParam, $param);

        $handle = fopen($file, 'r');

        $data = array();

        $first = true;
        $index = false;

        while (($line = fgetcsv($handle, $param['length'], $param['delimiter'], $param['enclosure'], $param['escape'])) !== FALSE) {
            if ($first) {
                if ($param['indexFromFirstRow']) {
                    $index = $line;
                }
            }

            if ($param['indexFromFirstRow'] && !$first || ($param['indexFromFirstRow'] && $param['skipFirstRow'] !== true)) {

                $newline = array();

                foreach ($line as $key => $value) {
                    if (isset($index[$key])) {
                        $newline[$index[$key]] = $value;
                    } else {
                        $newline[] = $value;
                    }
                }
                $data[] = $newline;
            } elseif (!$first || ($first && $param['skipFirstRow'] !== true)) {
                $data[] = $line;
            }

            $first = false;
        }

        fclose($handle);

        return $data;
    }

#D
    /**
     * Unsets dot-notated key from an array.
     *
     * @param array &$aSearch The search array
     * @param mixed $mFind The dot-notated key or array of keys
     *
     * @return mixed
     */
    public static function delete(&$aSearch, $mFind)
    {
        if (is_null($mFind)) {
            return false;
        }

        if (is_array($mFind)) {
            $return = array();

            foreach ($mFind as $key) {
                $return[$key] = self::delete($aSearch, $key);
            }

            return $return;
        }

        $keys = explode('.', $mFind);

        if (!is_array($aSearch) || !array_key_exists($keys[0], $aSearch)) {
            return false;
        }

        $this_key = array_shift($keys);

        if (!empty($keys)) {
            $key = implode('.', $keys);

            return self::delete($aSearch[$this_key], $key);
        } else {
            unset($aSearch[$this_key]);
        }

        return true;
    }

    /**
     * Transform an ArrayDotted to an array
     * @param $arrayDotted
     * @return array
     */
    public static function dot_array($arrayDotted)
    {
        $array = array();
        foreach ($arrayDotted as $key => $value) {
            self::array_set($array, $key, $value);
        }
        return $array;
    }
#E

#F

    /**
     * Filters an array by an array of keys
     *
     * @param the $array
     * @param   array   the array to filter.
     * @param bool $remove
     * @internal param \Arx\classes\if $bool true, removes the matched elements.
     * @return  array
     */
    public static function filter_keys($array, $keys, $remove = false)
    {
        $return = array();
        foreach ($keys as $key) {
            if (array_key_exists($key, $array)) {
                $remove or $return[$key] = $array[$key];
                if ($remove) {
                    unset($array[$key]);
                }
            }
        }
        return $remove ? $array : $return;
    }

    /**
     * Filters an array on prefixed associative keys.
     *
     * @param the $array
     * @param   array   the array to filter.
     * @param bool $remove_prefix
     * @internal param \Arx\classes\whether $bool to remove the prefix.
     * @return  array
     */
    public static function filter_prefixed($array, $prefix, $remove_prefix = true)
    {
        $return = array();
        foreach ($array as $key => $val) {
            if (preg_match('/^' . $prefix . '/', $key)) {
                if ($remove_prefix === true) {
                    $key = preg_replace('/^' . $prefix . '/', '', $key);
                }
                $return[$key] = $val;
            }
        }
        return $return;
    }

    /**
     * Filters an array on suffixed associative keys.
     *
     * @param the $array
     * @param   array   the array to filter.
     * @param bool $remove_suffix
     * @internal param \Arx\classes\whether $bool to remove the suffix.
     * @return  array
     */
    public static function filter_suffixed($array, $suffix, $remove_suffix = true)
    {
        $return = array();
        foreach ($array as $key => $val) {
            if (preg_match('/' . $suffix . '$/', $key)) {
                if ($remove_suffix === true) {
                    $key = preg_replace('/' . $suffix . '$/', '', $key);
                }
                $return[$key] = $val;
            }
        }
        return $return;
    }

    /**
     * Recursive version of PHP's array_filter()
     *
     * @param the $array
     * @param the|null $callback
     * @internal param \Arx\classes\the $array array to filter.
     * @internal param \Arx\classes\the $callback callback that determines whether or not a value is filtered
     * @return  array
     */
    public static function filter_recursive($array, $callback = null)
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = $callback === null ? static::filter_recursive($value) : static::filter_recursive($value, $callback);
            }
        }

        return $callback === null ? array_filter($array) : array_filter($array, $callback);
    }

    /**
     * Return first value of an array even if we don't know the key
     *
     * @param $array
     * @return mixed
     */
    public static function firstValue($array)
    {
        $first = array_values($array);
        return $first[0];
    }

    /**
     * Return first key of an array
     *
     * @param $array
     * @return mixed
     */
    public static function firstKey($array)
    {
        $first = array_keys($array);
        return $first[0];
    }

    /**
     * Flattens a multi-dimensional associative array down into a 1 dimensional
     * associative array.
     *
     * @param $array
     * @param string $glue
     * @param bool $reset
     * @param bool $indexed
     * @return array
     */
    public static function flatten($array, $glue = ':', $reset = true, $indexed = true)
    {
        static $return = array();
        static $curr_key = array();

        if ($reset) {
            $return = array();
            $curr_key = array();
        }

        foreach ($array as $key => $val) {
            $curr_key[] = $key;
            if (is_array($val) and ($indexed or array_values($val) !== $val)) {
                static::flatten_assoc($val, $glue, false);
            } else {
                $return[implode($glue, $curr_key)] = $val;
            }
            array_pop($curr_key);
        }
        return $return;
    }

    /**
     * Flattens a multi-dimensional associative array down into a 1 dimensional
     * associative array.
     *
     * @param the $array
     * @param string $glue what to glue the keys together with
     * @param bool $reset whether to reset and start over on a new array
     * @internal param \Arx\classes\the $array array to flatten
     * @return  array
     */
    public static function flatten_assoc($array, $glue = ':', $reset = true)
    {
        return static::flatten($array, $glue, $reset, false);
    }

#G
    /**
     * Gets a dot-notated key from an array, with a default value if it does not exist.
     *
     * @param array $aSearch The seach array
     * @param mixed $mFind The dot-notated key or array of keys
     * @param string $sDefault The default value
     *
     * @return mixed
     */
    public static function get($aSearch, $mFind, $sDefault = null)
    {
        if (is_null($mFind)) {
            return $aSearch;
        }

        if (is_array($mFind)) {
            $return = array();

            foreach ($mFind as $key) {
                $return[$key] = self::get($aSearch, $key, $sDefault);
            }

            return $return;
        }

        foreach (explode('.', $mFind) as $key) {
            if (!isset($aSearch[$key])) {
                if (!is_array($aSearch) || !array_key_exists($key, $aSearch)) {
                    return $sDefault;
                }
            }

            $aSearch = $aSearch[$key];
        }

        return $aSearch;
    }
#H

#I


    /**
     * Recursive in_array
     *
     * @param   mixed $needle what to search for
     * @param   array $haystack array to search in
     * @param bool $strict
     * @return  bool   wether the needle is found in the haystack.
     */
    public static function in_array_recursive($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $value) {
            if (!$strict and $needle == $value) {
                return true;
            } elseif ($needle === $value) {
                return true;
            } elseif (is_array($value) and static::in_array_recursive($needle, $value, $strict)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Insert value(s) into an array, mostly an array_splice alias
     * WARNING: original array is edited by reference, only boolean success is returned
     *
     * @param   array        the original array (by reference)
     * @param   array|mixed the value(s) to insert, if you want to insert an array it needs to be in an array itself
     * @param   int          the numeric position at which to insert, negative to count from the end backwards
     * @return  bool         false when array shorter then $pos, otherwise true
     */
    public static function insert(array &$original, $value, $pos)
    {
        if (count($original) < abs($pos)) {
            return false;
        }

        array_splice($original, $pos, 0, $value);

        return true;
    }

    /**
     * Insert value(s) into an array after a specific key
     * WARNING: original array is edited by reference, only boolean success is returned
     *
     * @param   array        the original array (by reference)
     * @param   array|mixed the value(s) to insert, if you want to insert an array it needs to be in an array itself
     * @param   string|int the key after which to insert
     * @param   bool         wether the input is an associative array
     * @return  bool         false when key isn't found in the array, otherwise true
     */
    public static function insert_after_key(array &$original, $value, $key, $is_assoc = false)
    {
        $pos = array_search($key, array_keys($original));

        if ($pos === false) {
            return false;
        }

        return $is_assoc ? static::insert_assoc($original, $value, $pos + 1) : static::insert($original, $value, $pos + 1);
    }

    /**
     * Insert value(s) into an array after a specific value (first found in array)
     *
     * @param   array        the original array (by reference)
     * @param   array|mixed the value(s) to insert, if you want to insert an array it needs to be in an array itself
     * @param   string|int the value after which to insert
     * @param   bool         wether the input is an associative array
     * @return  bool         false when value isn't found in the array, otherwise true
     */
    public static function insert_after_value(array &$original, $value, $search, $is_assoc = false)
    {
        $key = array_search($search, $original);

        if ($key === false) {
            return false;
        }

        return static::insert_after_key($original, $value, $key, $is_assoc);
    }

    /**
     * Insert value(s) into an array, mostly an array_splice alias
     * WARNING: original array is edited by reference, only boolean success is returned
     *
     * @param   array        the original array (by reference)
     * @param   array|mixed the value(s) to insert, if you want to insert an array it needs to be in an array itself
     * @param   int          the numeric position at which to insert, negative to count from the end backwards
     * @return  bool         false when array shorter then $pos, otherwise true
     */
    public static function insert_assoc(array &$original, array $values, $pos)
    {
        if (count($original) < abs($pos)) {
            return false;
        }

        $original = array_slice($original, 0, $pos, true) + $values + array_slice($original, $pos, null, true);

        return true;
    }

    /**
     * Insert value(s) into an array before a specific key
     * WARNING: original array is edited by reference, only boolean success is returned
     *
     * @param   array        the original array (by reference)
     * @param   array|mixed the value(s) to insert, if you want to insert an array it needs to be in an array itself
     * @param   string|int the key before which to insert
     * @param   bool         wether the input is an associative array
     * @return  bool         false when key isn't found in the array, otherwise true
     */
    public static function insert_before_key(array &$original, $value, $key, $is_assoc = false)
    {
        $pos = array_search($key, array_keys($original));

        if ($pos === false) {
            return false;
        }

        return $is_assoc ? static::insert_assoc($original, $value, $pos) : static::insert($original, $value, $pos);
    }

    /**
     * Insert value(s) into an array before a specific value (first found in array)
     *
     * @param   array        the original array (by reference)
     * @param   array|mixed the value(s) to insert, if you want to insert an array it needs to be in an array itself
     * @param   string|int the value after which to insert
     * @param   bool         wether the input is an associative array
     * @return  bool         false when value isn't found in the array, otherwise true
     */
    public static function insert_before_value(array &$original, $value, $search, $is_assoc = false)
    {
        $key = array_search($search, $original);

        if ($key === false) {

            return false;
        }

        return static::insert_before_key($original, $value, $key, $is_assoc);
    }


    /**
     * Checks if the given array is an assoc array.
     *
     * @param   array $arr the array to check
     * @throws \InvalidArgumentException
     * @return  bool   true if its an assoc array, false if not
     */
    public static function is_assoc($arr)
    {
        if (!is_array($arr)) {
            throw new \InvalidArgumentException('The parameter must be an array.');
        }

        $counter = 0;
        foreach ($arr as $key => $unused) {

            if (!is_int($key) || $key !== $counter) {
                return true;
            }

            $counter++;
        }
        return false;
    }

    /**
     * Checks if the given array is a multidimensional array.
     *
     * @param   array $arr the array to check
     * @param array|bool $all_keys if true, check that all elements are arrays
     * @return  bool   true if its a multidimensional array, false if not
     */
    public static function is_multi($arr, $all_keys = false)
    {
        $values = array_filter($arr, 'is_array');
        return $all_keys ? count($arr) === count($values) : count($values) > 0;
    }


    /**
     * Checks if the given array is an assoc array.
     *
     * @param   array $arr the array to check
     * @throws \InvalidArgumentException
     * @return  bool   true if its an assoc array, false if not
     */
    public static function is_sequential($arr)
    {
        if (!is_array($arr)) {
            return false;
        }

        $counter = 0;

        foreach ($arr as $key => $unused) {
            if (!is_int($key) || $key != $counter) {
                return false;
            }
            $counter++;
        }

        return true;
    }

#J

#K

    /**
     * Array_key_exists with a dot-notated key from an array.
     *
     * @param   array $array The search array
     * @param   mixed $key The dot-notated key or array of keys
     * @return  mixed
     */
    public static function keyExists($array, $key)
    {
        foreach (explode('.', $key) as $key_part) {
            if (!is_array($array) or !array_key_exists($key_part, $array)) {
                return false;
            }

            $array = $array[$key_part];
        }

        return true;
    }


    /**
     * Get key of index
     *
     * @param $array
     * @param $index
     * @param bool $strict if strict = true => will trigger an error if index is not defined => if not return false
     * @return bool
     */
    public static function keyOf($array, $index, $strict = false)
    {

        $array = array_keys($array);

        if ($array[$index] || $strict) {
            return $array[$index];
        }

        return null;
    }

#L


    /**
     * Return last value of an array
     *
     * @param $array
     * @return mixed
     */
    public static function lastValue($array)
    {
        $first = array_values($array);
        return $first[count($array) - 1];
    }

    /**
     * Return last key of an array
     *
     * @param $array
     * @return mixed
     */
    public static function lastKey($array)
    {
        $first = array_keys($array);
        return $first[count($array) - 1];
    }

#M


    /**
     * Merge 2 Arr recursively
     *
     * @throws \Exception
     * @return array
     */
    public static function merge()
    {
        $array = func_get_arg(0);
        $Arr = array_slice(func_get_args(), 1);

        if (!is_array($array)) {
            throw new \Exception('Arr::merge() - all arguments must be Array.');
        }

        foreach ($Arr as $arr) {
            if (!is_array($arr)) {
                throw new \Exception('Arr::merge() - all arguments must be Array.');
            }

            foreach ($arr as $key => $value) {
                if (is_int($key)) {
                    array_key_exists($key, $array) ? array_push($array, $value) : $array[$key] = $value;
                } elseif (is_array($value) && array_key_exists($key, $array) && is_array($array[$key])) {
                    $array[$key] = self::merge($array[$key], $value);
                } else {
                    $array[$key] = $value;
                }
            }
        }

        return $array;
    } // merge


    /**
     * Merge params value with default params
     *
     * @throws \Exception
     * @return array
     */
    public static function mergeWithDefaultParams(&$params, $name = 'params')
    {
        $callers = debug_backtrace();

        if (isset($callers[1]['class'])) {
            $method = new ReflectionMethod($callers[1]['class'], $callers[1]['function']);
        } elseif (isset($callers[1]['function'])) {
            $method = new \ReflectionFunction($callers[1]['function']);
        } else {
            Throw new \Exception('Cannot resolve params merging');
        }

        $defParams = array();

        foreach ($method->getParameters() as $param) {
            if ($param->name == $name) {
                $defParams = $param->getDefaultValue();
            }
        }

        $params = array_merge($defParams, $params);

        return $params;
    }


    /**
     * Explode in multilevel array
     *
     * @param array $l
     * @param string $s
     * @return array
     */
    public static function multiexplode($l = array(), $s = '')
    {
        $tr[0] = explode($l[0], $s);
        $msg = array();

        foreach ($tr[0] as $t) {
            $r = explode($l[1], $t);
            $rKey = trim($r[0]);
            $msg[$rKey] = $r[1];
        }

        return $msg;
    }

    /**
     * Sorts an array on multitiple values, with deep sorting support.
     *
     * @param   array $array collection of arrays/objects to sort
     * @param   array $conditions sorting conditions
     * @param   bool @ignore_case  wether to sort case insensitive
     * @return array
     * @return array
     */
    public static function multisort($array, $conditions, $ignore_case = false)
    {
        $temp = array();
        $keys = array_keys($conditions);

        foreach ($keys as $key) {
            $temp[$key] = static::pluck($array, $key, true);
            is_array($conditions[$key]) or $conditions[$key] = array($conditions[$key]);
        }

        $args = array();
        foreach ($keys as $key) {
            $args[] = $ignore_case ? array_map('strtolower', $temp[$key]) : $temp[$key];
            foreach ($conditions[$key] as $flag) {
                $args[] = $flag;
            }
        }

        $args[] = &$array;

        call_user_func_array('array_multisort', $args);
        return $array;
    }
#N


    /**
     * Get the next value or key from an array using the current array key
     *
     * @param   array $array the array containing the values
     * @param string $key if true, do a strict key comparison
     *
     * @param bool $get_value
     * @param bool $strict
     * @throws \InvalidArgumentException
     * @return  mixed  the value in the array, null if there is no next value, or false if the key doesn't exist
     */
    public static function next_by_key($array, $key, $get_value = false, $strict = false)
    {
        if (!is_array($array) and !$array instanceof \ArrayAccess) {
            throw new \InvalidArgumentException('First parameter must be an array or ArrayAccess object.');
        }

        // get the keys of the array
        $keys = array_keys($array);

        // and do a lookup of the key passed
        if (($index = array_search($key, $keys, $strict)) === false) {
            // key does not exist
            return false;
        } // check if we have a previous key
        elseif (!isset($keys[$index + 1])) {
            // there is none
            return null;
        }

        // return the value or the key of the array entry the previous key points to
        return $get_value ? $array[$keys[$index + 1]] : $keys[$index + 1];
    }

    /**
     * Get the next value or key from an array using the current array value
     *
     * @param   array $array the array containing the values
     * @param   string $value value of the current entry to use as reference
     * @param bool $get_value
     * @param bool $strict
     * @throws \InvalidArgumentException
     * @internal param bool $key if true, return the next value instead of the next key
     * @internal param bool $key if true, do a strict key comparison
     *
     * @return  mixed  the value in the array, null if there is no next value, or false if the key doesn't exist
     */
    public static function next_by_value($array, $value, $get_value = true, $strict = false)
    {
        if (!is_array($array) and !$array instanceof \ArrayAccess) {
            throw new \InvalidArgumentException('First parameter must be an array or ArrayAccess object.');
        }

        // find the current value in the array
        if (($key = array_search($value, $array, $strict)) === false) {
            // bail out if not found
            return false;
        }

        // get the list of keys, and find our found key
        $keys = array_keys($array);
        $index = array_search($key, $keys);

        // if there is no next one, bail out
        if (!isset($keys[$index + 1])) {
            return null;
        }

        // return the value or the key of the array entry the next key points to
        return $get_value ? $array[$keys[$index + 1]] : $keys[$index + 1];
    }

#O

    /**
     * Transform an Object to Array
     *
     * @param $object
     * @deprecated please use toArray instead
     * @return mixed
     */
    public static function objectToArray($object)
    {
        return json_decode(json_encode($object), true);
    }

    /**
     * Overwrite value
     *
     * @param $array1
     * @param $array2
     * @return mixed
     */
    public static function overwrite($array1, $array2)
    {
        foreach (array_intersect_key($array2, $array1) as $key => $value) {
            $array1[$key] = $value;
        }

        if (func_num_args() > 2) {
            foreach (array_slice(func_get_args(), 2) as $array2) {
                foreach (array_intersect_key($array2, $array1) as $key => $value) {
                    $array1[$key] = $value;
                }
            }
        }

        return $array1;
    }
#P


    /**
     * Prepends a value with an asociative key to an array.
     * Will overwrite if the value exists.
     *
     * @param   array $arr the array to prepend to
     * @param   string|array $key the key or array of keys and values
     * @param null $value
     * @internal param mixed $valye the value to prepend
     */
    public static function prepend(&$arr, $key, $value = null)
    {
        $arr = (is_array($key) ? $key : array($key => $value)) + $arr;
    }

    /**
     * Pluck an array of values from an array.
     *
     * @param $array
     * @param $key
     * @param null $index
     * @return array
     */
    public static function pluck($array, $key, $index = null)
    {
        $return = array();
        $get_deep = strpos($key, '.') !== false;

        if (!$index) {
            foreach ($array as $a) {
                $return[] = (is_object($a) and !($a instanceof \ArrayAccess)) ? $a->{$key} :
                    ($get_deep ? static::get($a, $key) : $a[$key]);
            }
        } else {
            foreach ($array as $i => $a) {
                $index !== true and $i = (is_object($a) and !($a instanceof \ArrayAccess)) ? $a->{$index} : $a[$index];
                $return[$i] = (is_object($a) and !($a instanceof \ArrayAccess)) ? $a->{$key} :
                    ($get_deep ? static::get($a, $key) : $a[$key]);
            }
        }

        return $return;
    }


    /**
     * Get the previous value or key from an array using the current array key
     *
     * @param   array $array the array containing the values
     * @param string $key if true, do a strict key comparison
     *
     * @param bool $get_value
     * @param bool $strict
     * @throws \InvalidArgumentException
     * @return  mixed  the value in the array, null if there is no previous value, or false if the key doesn't exist
     */
    public static function previous_by_key($array, $key, $get_value = false, $strict = false)
    {
        if (!is_array($array) and !$array instanceof \ArrayAccess) {
            throw new \InvalidArgumentException('First parameter must be an array or ArrayAccess object.');
        }

        // get the keys of the array
        $keys = array_keys($array);

        // and do a lookup of the key passed
        if (($index = array_search($key, $keys, $strict)) === false) {
            // key does not exist
            return false;
        } // check if we have a previous key
        elseif (!isset($keys[$index - 1])) {
            // there is none
            return null;
        }

        // return the value or the key of the array entry the previous key points to
        return $get_value ? $array[$keys[$index - 1]] : $keys[$index - 1];
    }

    /**
     * Get the previous value or key from an array using the current array value
     *
     * @param   array $array the array containing the values
     * @param   string $value value of the current entry to use as reference
     * @param bool $get_value
     * @param bool $strict
     * @throws \InvalidArgumentException
     * @internal param bool $key if true, return the previous value instead of the previous key
     * @internal param bool $key if true, do a strict key comparison
     *
     * @return  mixed  the value in the array, null if there is no previous value, or false if the key doesn't exist
     */
    public static function previous_by_value($array, $value, $get_value = true, $strict = false)
    {
        if (!is_array($array) and !$array instanceof \ArrayAccess) {
            throw new \InvalidArgumentException('First parameter must be an array or ArrayAccess object.');
        }

        // find the current value in the array
        if (($key = array_search($value, $array, $strict)) === false) {
            // bail out if not found
            return false;
        }

        // get the list of keys, and find our found key
        $keys = array_keys($array);
        $index = array_search($key, $keys);

        // if there is no previous one, bail out
        if (!isset($keys[$index - 1])) {
            return null;
        }

        // return the value or the key of the array entry the previous key points to
        return $get_value ? $array[$keys[$index - 1]] : $keys[$index - 1];
    }

#Q

#R

    /**
     * Removes items from an array that match a key prefix.
     *
     * @param the $array
     * @param   array   the array to remove from
     * @return  array
     */
    public static function remove_prefixed($array, $prefix)
    {
        foreach ($array as $key => $val) {
            if (preg_match('/^' . $prefix . '/', $key)) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * Replaces key names in an array by names in $replace
     *
     * @param $source
     * @param $replace
     * @param null $new_key
     * @throws \InvalidArgumentException
     * @internal param \Arx\classes\the $array array containing the key/value combinations
     * @internal param array|string $key to replace or array containing the replacement keys
     * @internal param \Arx\classes\the $string replacement key
     * @return  array            the array with the new keys
     */
    public static function replace_key($source, $replace, $new_key = null)
    {
        if (is_string($replace)) {
            $replace = array($replace => $new_key);
        }

        if (!is_array($source) or !is_array($replace)) {
            throw new \InvalidArgumentException('Arr::replace_key() - $source must an array. $replace must be an array or string.');
        }

        $result = array();

        foreach ($source as $key => $value) {
            if (array_key_exists($key, $replace)) {
                $result[$replace[$key]] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Reverse a flattened array in its original form.
     *
     * @param   array $array flattened array
     * @param   string $glue glue used in flattening
     * @return  array   the unflattened array
     */
    public static function reverse_flatten($array, $glue = ':')
    {
        $return = array();

        foreach ($array as $key => $value) {
            if (stripos($key, $glue) !== false) {
                $keys = explode($glue, $key);
                $temp =& $return;
                while (count($keys) > 1) {
                    $key = array_shift($keys);
                    $key = is_numeric($key) ? (int)$key : $key;
                    if (!isset($temp[$key]) or !is_array($temp[$key])) {
                        $temp[$key] = array();
                    }
                    $temp =& $temp[$key];
                }

                $key = array_shift($keys);
                $key = is_numeric($key) ? (int)$key : $key;
                $temp[$key] = $value;
            } else {
                $key = is_numeric($key) ? (int)$key : $key;
                $return[$key] = $value;
            }
        }

        return $return;
    }


    /**
     * Removes items from an array that match a key suffix.
     *
     * @param the $array
     * @param   array   the array to remove from
     * @return  array
     */
    public static function remove_suffixed($array, $suffix)
    {
        foreach ($array as $key => $val) {
            if (preg_match('/' . $suffix . '$/', $key)) {
                unset($array[$key]);
            }
        }
        return $array;
    }
#S


    /**
     * Searches the array for a given value and returns the
     * corresponding key or default value.
     * If $recursive is set to true, then the Arr::search()
     * function will return a delimiter-notated key using $delimiter.
     *
     * @param   array $array The search array
     * @param   mixed $value The searched value
     * @param   string $default The default value
     * @param   bool $recursive Whether to get keys recursive
     * @param   string $delimiter The delimiter, when $recursive is true
     * @throws \InvalidArgumentException
     * @return  mixed
     */
    public static function search($array, $value, $default = null, $recursive = true, $delimiter = '.')
    {
        if (!is_array($array) and !$array instanceof \ArrayAccess) {
            throw new \InvalidArgumentException('First parameter must be an array or ArrayAccess object.');
        }

        if (!is_null($default) and !is_int($default) and !is_string($default)) {
            throw new \InvalidArgumentException('Expects parameter 3 to be an string or integer or null.');
        }

        if (!is_string($delimiter)) {
            throw new \InvalidArgumentException('Expects parameter 5 must be an string.');
        }

        $key = array_search($value, $array);

        if ($recursive and $key === false) {
            $keys = array();
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    $rk = static::search($v, $value, $default, true, $delimiter);
                    if ($rk !== $default) {
                        $keys = array($k, $rk);
                        break;
                    }
                }
            }
            $key = count($keys) ? implode($delimiter, $keys) : false;
        }

        return $key === false ? $default : $key;
    }


    /**
     * Sorts a multi-dimensional array by it's values.
     *
     * @param $array
     * @param $key
     * @param string $order
     * @param int $sort_flags
     * @return array
     */
    public static function sort($array, $key, $order = 'asc', $sort_flags = SORT_REGULAR)
    {
        $c = [];

        if (!is_array($array)) {
            throw new \InvalidArgumentException('Arr::sort() - $array must be an array.');
        }

        if (empty($array)) {
            return $array;
        }

        foreach ($array as $k => $v) {
            $b[$k] = static::get($v, $key);
        }

        switch ($order) {
            case 'asc':
                asort($b, $sort_flags);
                break;

            case 'desc':
                arsort($b, $sort_flags);
                break;

            default:
                throw new \InvalidArgumentException('Arr::sort() - $order must be asc or desc.');
                break;
        }

        foreach ($b as $key => $val) {
            $c[] = $array[$key];
        }

        return $c;
    }


    /**
     * Set an array item (dot-notated) to the value.
     *
     * @param array &$aArray The array to insert it into
     * @param mixed $mFind The dot-notated key to set or array of keys
     * @param mixed $mValue The value
     *
     * @return void
     */
    public static function set(&$aArray, $mFind, $mValue = null)
    {
        if (is_null($mFind)) {
            $aArray = !is_null($mValue) ? $mValue : $aArray;
            return;
        }

        if (is_array($mFind)) {
            foreach ($mFind as $key => $value) {
                self::set($aArray, $key, $value);
            }
        } else {
            $keys = explode('.', $mFind);

            while (count($keys) > 1) {
                $mFind = array_shift($keys);

                if (!isset($aArray[$mFind]) || !is_array($aArray[$mFind])) {
                    $aArray[$mFind] = array();
                }

                $aArray =& $aArray[$mFind];
            }

            $aArray[reset($keys)] = $mValue;
        }
    } // set


    /**
     * Suckplode : add a value to a string seperated by a separator
     *
     * @example :
     *          Arr::suckplode('e', 'a,b,c,d', ',')
     *          will return "a,b,c,d,e"
     *
     *          Arr::suckplode('e', 'a,b,c,d,e', ',')
     *          will return "a,b,c,d,e"
     *
     *          Arr::suckplode('e', 'a,b,c,d', ',', false)
     *          will return "a,b,c,d,e,e"
     *
     * @param  string $value
     * @param  string $string to add
     * @param  string $sep $separator
     * @param  bool $unique define if the value should be unique
     * @return string
     */
    public static function suckplode($value, $string, $sep = ',', $unique = true)
    {
        $array = explode($sep, $string);

        if ($unique == true && in_array($value, $array)) {
            return $string;
        }

        array_push($array, $value);

        return implode($sep, array_filter($array));
    }


    /**
     * Calculate the sum of an array
     *
     * @param   array $array the array containing the values
     * @param   string $key key of the value to pluck
     * @throws \InvalidArgumentException
     * @return  numeric  the sum value
     */
    public static function sum($array, $key)
    {
        if (!is_array($array) and !$array instanceof \ArrayAccess) {
            throw new \InvalidArgumentException('First parameter must be an array or ArrayAccess object.');
        }

        return array_sum(static::pluck($array, $key));
    }
#T

    /**
     * Trying to transfrom anything to Array
     *
     * @param $mValue
     * @return mixed
     */
    public static function toArray($mValue)
    {
        return json_decode(json_encode($mValue), true);
    }

    /**
     * Trying to transform anything to Object
     * @param $mValue
     * @return mixed
     */
    public static function toObject($mValue)
    {
        return json_decode(json_encode($mValue));
    }

    /**
     * Trying to transform anything to Json string
     * @param $mValue
     * @return string
     */
    public static function toJson($mValue)
    {
        return json_encode($mValue);
    }

#U
    /**
     * Returns only unique values in an array. It does not sort. First value is used.
     *
     * @param   array $arr the array to dedup
     * @return  array   array with only de-duped values
     */
    public static function unique($arr)
    {
        // filter out all duplicate values
        return array_filter($arr, function ($item) {
            // contrary to popular belief, this is not as static as you think...
            static $vars = array();

            if (in_array($item, $vars, true)) {
                // duplicate
                return false;
            } else {
                // record we've had this value
                $vars[] = $item;

                // unique
                return true;
            }
        });
    }
#V

    /**
     * Return value of a particular index
     *
     * @param $array
     * @param $index
     * @param bool $strict if strict = true => will trigger an error if index is not defined => if not return false
     * @return bool
     */
    public static function valueOf($array, $index, $strict = false)
    {

        $array = array_values($array);

        if ($array[$index] || $strict) {
            return $array[$index];
        }

        return null;
    }
#W

#X

#Y

#Z

}
