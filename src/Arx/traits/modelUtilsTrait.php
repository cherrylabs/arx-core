<?php namespace Arx\traits;

use Input;

trait modelUtilsTrait
{
    private static $_aInstances = array();

    public static $structure;

    /**
     * @return mixed
     */
    public static function getInstance(){
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }

    /**
     * Tranform an array to a valid Regex format
     * @param $array
     * @return mixed
     */
    public static function arrayToRegex($array)
    {
        if (isset($array)) {
            foreach ($array as $k => $item) {
                if(is_string($item)){
                    $array[$k] = $item;
                } else {
                    $array[$k] = "\"".$item."\"";
                }
            }
        }

        return implode('|', $array);
    }

    /**
     * Prepare input for query
     *
     * @param array $param
     * @return array
     */
    public static function prepareParams(array $param){

        $fillable = static::getInstance()->getFillables();

        foreach($param as $key => $value){
            if(!in_array($key, $fillable)){
                unset($param[$key]);
            } elseif(!$value){
                unset($param[$key]);
            }
        }

        return $param;
    }

    /**
     * Get fillables columns from model helpers
     *
     * @return array
     */
    public static function getFillables()
    {
        $instance = static::getInstance();

        $fillable = $instance->fillable;

        if($fillable == array('*') || !$fillable){
            $instance->fillable = array_keys($instance->getStructure());
        }

        return $instance->fillable;
    }

    /**
     * Get Rules from Model
     */
    public static function getRules()
    {
        $instance = static::getInstance();

        $fillables = $instance->getFillables();

        $structure = $instance->getStructure();

        $rules = $instance->rules;

        if(!$rules){
            $rules = [];

            foreach($structure as $key => $column){
                $rules[$key] = '';
            }
        }

        return $rules;
    }

    /**
     * Get Structure from DB
     *
     * @return \Doctrine\DBAL\Schema\Column[]
     */
    public static function getStructure()
    {
        if(!static::$structure){
            static::$structure = \DB::getDoctrineSchemaManager()->listTableColumns(static::getInstance()->getTable());
        }

        return static::$structure;
    }

}