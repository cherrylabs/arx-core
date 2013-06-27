<?php namespace Arx\classes;
/**
 * Arx
 * PHP File - /classes/Arrays.php
 */


abstract class Arrays
{

    /**
     * Unsets dot-notated key from an array.
     *
     * @param  array  $aSearch The search array
     * @param  mixed  $mFind   The dot-notated key or array of keys
     * @return mixed
     */
    public static function delete(&$aSearch, $mFind) {
        if (is_null($mFind)) {
            return false;
        }

        if (is_array($mFind)) {
            $return = array();

            foreach ($mFind as $key) {
                $return[$key] = static::delete($aSearch, $key);
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

            return static::delete($aSearch[$this_key], $key);
        } else {
            unset($aSearch[$this_key]);
        }

        return true;
    } // delete


    /**
     * Gets a dot-notated key from an array, with a default value if it does not exist.
     *
     * @param  array  $aSearch  The seach array
     * @param  mixed  $mFind    The dot-notated key or array of keys
     * @param  string $sDefault The default value
     * @return mixed
     */
    public static function get($aSearch, $mFind, $sDefault = null) {
        if (is_null($mFind)) {
            return $aSearch;
        }

        if (is_array($mFind)) {
            $return = array();

            foreach ($mFind as $key) {
                $return[$key] = static::get($aSearch, $key, $sDefault);
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


    /**
     * Merge 2 arrays recursively.
     *
     * @param  array  Multiple variables all of which must be arrays
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function merge() {
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
                    $array[$key] = static::merge($array[$key], $value);
                } else {
                    $array[$key] = $value;
                }
            }
        }

        return $array;
    } // merge


    /**
     * Set an array item (dot-notated) to the value.
     *
     * @param  array  $aArray The array to insert it into
     * @param  mixed  $mFind  The dot-notated key to set or array of keys
     * @param  mixed  $mValue The value
     * @return void
     */
    public static function set(&$aArray, $mFind, $mValue = null) {
        if (is_null($mFind)) {
            $aArray = $mValue;
            return;
        }

        if (is_array($mFind)) {
            foreach ($mFind as $key => $value) {
                static::set($aArray, $key, $value);
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

            $aArray[array_shift($mFind)] = $mValue;
        }
    } // set

} // class::Arrays
