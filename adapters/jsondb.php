<?php
/**
 * JSONDb - Convert a JSON file to Object. Save JSON to file. etc.
 *
 * @author	St?phan Zych (http://monkeymonk.be/)
 * @version 0.0.1 (03/07/2012)
 */

class JSONDb {
    private $file = null;
    private $data = null;


    public function __construct($file = null) {
        if (!is_null($file)) {
            $this->file = $file;
            $this->open($file);
        } else {
            $this->data = json_decode("{}");
        }
    } // __construct


    public function __isset($field) {
        return isset($this->datas->{$field});
    } // __isset


    public function __get($field) { // &
        return $this->get($field);
    } // __get


    public function __set($field, $value = null) {
        return $this->set($field, $value);
    } // __set


    public function open() {
        if (file_exists($this->file)) {
            $this->data = file_get_contents($this->file);

            if (!empty($this->data)) {
                $this->data = json_decode($this->data);
            } else {
                $this->data = json_decode("{}");
            }
        }

        return $this;
    } // open


    public function get($field) {
        if (property_exists($this->data, $field)) {
            return $this->data->{$field};
        }

        return null;
    } // get


    public function set($field, $value) {
        if (is_array($value)) {
            $value = self::arrayToObject($value);
        }

        $this->data->{$field} = $value;

        return $this;
    } // set


    public function save($file = null) {
        if (is_null($this->file) && is_null($file)) {
            return false;
        }

        if (is_null($file)) {
            $file = $this->file;
        }

        $json = json_encode($this->data);

        $fp = fopen($file, "w+");
        
        if ($fp) {
            fwrite($fp, $json);
            fclose($fp);

            return true;
        }

        return false;
    } // save


    public function find($value, $boolean = false) {
        // find an entry who match $value
        // if $boolean -> return true when a result is find
        // else -> return the matched object
        if (is_array($value)) {
            // trying to match multiple case (recursive)
        }
        /*
$ret = false;

        if (is_object($obj)) {
            foreach ($obj as $k => $v) {
                if (is_object($v)) {
                    $ret = self::_find($find, $v);
                }
                if ($find == $v) {
                    $ret = $obj;
                }
            }
        }

        return $ret;
*/
    } // find


    public function remove() {} // remove


    public static function arrayToObject($array) {
        if (is_array($array)) {
            return (object) array_map(array('JSONFile', 'arrayToObject'), $array);
        } else {
            return $array;
        }
    } // arrayToObject


    public static function in_object($find, $object) {
        if (is_object($object)) {
            foreach ($object as $k => $v) {
                if (is_object($v)) {
                    return self::in_object($find, $v);
                }

                if ($find == $k) {
                    return $v;
                }
            }
        }

        return false;
    } // in_object

} // adapter:JSONDb
