<?php namespace Arx\classes;

/**
 * Arrays
 *
 * @category Utils
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Arrays
 */
abstract class Arrays
{

    /**
     * Array_assign_key assign the key
     * example array_assign_keys(array(0 => array("name" => B), 1 => array("name" => "A")), "name")
     * will return array("A" => array("name" => B, "__key" => "1"), "B" => array("name" => B, "__key" => "0"))
     * @param $array, $key
     *
     * @return
     *
     * @code
     *
     * @endcode
     */
    public static function array_assign_subkey($arr, $context = array(), &$conflict = array()) {
        $aNew = array();

        //default option
        $c = array(
            "old_key" => "_key"
        );

        if (is_string($context)) {
            $c['key'] = $context;
        } elseif (is_array($context)) {
            $c = array_merge($c, $context);
        }

        foreach ($arr as $key=>$v) {
            if (is_object($v)) {

            } elseif (is_array($v)) {
                if (isset($v[$c['key']])) {
                    if(!isset($c['delete_old_key']))    $v[$c['old_key']] = $key;

                    $aNew[$v[$c['key']]] = $v;
                }
            }
        }

        return $aNew;
    } // array_assign_subkey


    /**
     * Divide array into multilple
     * @param  array  $array        array to divide
     * @param  integer $nb           nb of array to return
     * @param  boolean $preserve_key preserve key or not
     * @return array                arrays splitted
     */
    public static function array_divide($array, $nb = 2, $preserve_key = true) {
        $iMiddle = round(count($array) / $nb, 0, PHP_ROUND_HALF_UP);
        return array_chunk($array, $iMiddle, $preserve_key);
    } // array_divide


    /**
     * Diverse array with a specific value
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
    public static function array_diverse($array) {
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
    } // array_diverse


    public static function array_filter_keys($array, $c = null) {

        $isMultidimensionnal = self::is_multi_array($array);

        if (is_string($c)) {
            $c = array('with' => $c);
        }

        if (isset($c['with'])) {
            $data = array();

            if (!$isMultidimensionnal) {
                foreach ($array as $key=>$v) {
                    if (preg_match('/'.$c['with'].'/i', $key)) {
                        $data[$key] = $v;
                    }
                }
            } else {
                foreach ($array as $k1=>$v1) {
                    foreach ($v1 as $key=>$value) {
                        if (preg_match('/'.$c['with'].'/i', $key)) {
                            $data[$key] = $v;
                        }
                    }
                }
            }

            return $data;
        } else {
            return array_filter($array);
        }

    } // array_filter_keys


    public static function array_filter_values($array, $c = null) {
        if (isset($c['with'])) {
            $data = array();

            foreach ($a as $key=>$value) {
                if (strpos($v, $c['with'])) {
                    $data[$key] = $value;
                }
            }

            return $data;
        } else {
            return array_filter($a);
        }
    } // array_filter_values


    /**
     * return the next element of a specific key
     *
     * @param $
     *
     * @return
     *
     * @code
     *
     * @endcode
     */
    public static function array_next_element($arr, $nested_key, $iteration = 1) {
        foreach ($arr as $key=>$v) {
            current($arr);

            if ($key == $nested_key) {
                for ($i =0; $i < $iteration; $i++) {
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
    } // array_next_element


    public static function array_prev_element($arr, $nested_key, $iteration = 1) {
        foreach ($arr as $key=>$v) {
            if ($key == $nested_key) {
                for ($i =0; $i < $iteration; $i++) {
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
    } // array_prev_element


    public static function arrayToCSV($data) {
        $outstream = fopen("php://temp", 'r+');
        fputcsv($outstream, $data, ',', '"');
        rewind($outstream);
        $csv = fgets($outstream);
        fclose($outstream);

        return $csv;
    } // arrayToCSV


    /**
     * Unsets dot-notated key from an array.
     *
     * @param array &$aSearch The search array
     * @param mixed $mFind    The dot-notated key or array of keys
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
    } // delete


    /**
     * Gets a dot-notated key from an array, with a default value if it does not exist.
     *
     * @param array  $aSearch  The seach array
     * @param mixed  $mFind    The dot-notated key or array of keys
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
    } // get


    public static function is_multi_array($arr) {
        if (count($myarray) == count($myarray, COUNT_RECURSIVE)) {
          return false;
        } else {
          return true;
        }
    } // is_multi_array


    /**
     * Merge 2 arrays recursively.
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function merge()
    {
        $array = func_get_arg(0);
        $arrays = array_slice(func_get_args(), 1);

        if (!is_array($array)) {
            throw new \Exception('Arrays::merge() - all arguments must be arrays.');
        }

        foreach ($arrays as $arr) {
            if (!is_array($arr)) {
                throw new \Exception('Arrays::merge() - all arguments must be arrays.');
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


    public static function multiexplode($l = array(), $s = '') {
        $tr[0] = explode($l[0], $s);
        $msg = array();

        #TO DO : a more recursive function_exists
        foreach ($tr[0] as $key=>$t) {
            $r = explode($l[1], $t);
            $rKey = trim($r[0]);
            $msg[$rKey] = $r[1];
        }

        return $msg;
    } // multiexplode


    public static function objectToArray($d) {
        // Gets the properties of the given object with get_object_vars function
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        // Return array converted to object (recursive call)
        if (is_array($d)) {
            return array_map(array('u', 'objectToArray'), $d);
        }
        // Return array
        else {
            return $d;
        }
    } // objectToArray


    /**
     * Set an array item (dot-notated) to the value.
     *
     * @param array &$aArray The array to insert it into
     * @param mixed $mFind   The dot-notated key to set or array of keys
     * @param mixed $mValue  The value
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
     * @param  string $value
     * @param  string $string to add
     * @param  string $sep    $separator
     * @param  bool   $unique define if the value should be unique
     * @return string
     */
    public static function suckplode($value, $string, $sep = ',', $unique = true) {
        $array = explode($sep, $string);

        if ($unique == true && in_array($value, $array)) {
            return $string;
        }

        array_push($array, $value);

        return implode($sep, array_filter($array));
    } // suckplode


    /**
     * Transform a string to array using json, or lazy encode
     * @param mix $s mix string
     * @param array $c options
     * @return array    array
     */
    public static function toArray($s, $c = null) {
        $array = array();

        if (is_string($s)) {
            switch (true) {
                case(strpos($s, '{')):
                    $_type = 'json';
                    $array = json_decode($s, true);
                    break;

                case(preg_match('/,/i', $s) && !preg_match('/=/i', $s)):
                    $_type = 'explode';
                    $array = explode(',', $s);
                    break;

                case(preg_match('/,/i', $s)):
                    $_type = 'lazy';
                    $array = self::lazy_decode($s);
                    predie($array);
                    break;
            }

        } elseif (is_object($s)) {
            return self::objectToArray($s);
        } else {
            $array = $s;
        }

        if ($c == 'DEBUG') {
            predie($s);
        }

        switch (true) {
            case ($c == 'DEBUG'):
            case ($c == 'debug'):
                predie(
                    array($s, $array, $_type)
                );
                break;
        }

        return $array;

    } // toArray

} // class::Arrays
