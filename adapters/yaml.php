<?php
/**
     * A Yaml cruncher
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
*/

require_once DIR_LIBS .'/Spyc/spyc.php';

abstract class a_yaml extends Spyc
{
    /**
         *
         * @author Daniel Sum
         * @version 0.1
         * @package arx
         * @description :
         * @comments :
    */
    public static function read($input)
    {
    $Spyc = new Spyc;

    return $Spyc->__load($input);
    }

    public static function create($input)
    {
    $Spyc = new Spyc;

    return $Spyc->__load($input);
    }

    public static function update($input)
    {
    $Spyc = new Spyc;

    return $Spyc->__load($input);
    }

    public static function delete($input)
    {
    $Spyc = new Spyc;

    return $Spyc->__load($input);
    }

}

if (!function_exists('yaml_decode')) {
  /**
   * Parses YAML to array.
   * @param string $string YAML string.
   * @return array
   */
  public function yaml_decode($string)
  {
    return Spyc::yaml_decode($string);
  }
}

if (!function_exists('yaml_load_file')) {
  /**
   * Parses YAML to array.
   * @param string $file Path to YAML file.
   * @return array
   */
  public function yaml_load_file($file)
  {
    return Spyc::YAMLLoad($file);
  }
}

if (!function_exists('yaml_encode')) {
  /**
   * Parses YAML to array.
   * @param string $file Path to YAML file.
   * @return array
   */
  public function yaml_encode($array = array())
  {
       if(!is_array($array)) $array = u::toArray($array);

       $yaml = new Spyc();

    return $yaml->dump($array);
  }
}

if (!function_exists('yaml_save_file')) {
  /**
   * Parses YAML to array.
   * @param string $file Path to YAML file.
   * @return array
   */
  public function yaml_save_file($file, $array = array(), $FLAGS = 0)
  {
       if(!is_array($array)) $array = u::toArray($array);

       $yaml = new Spyc();

    file_put_contents($file, $yaml->dump($array), $FLAGS);
  }
}
