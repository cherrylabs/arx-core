<?php namespace Arx;

use Illuminate\Database\Eloquent\Model as ParentClass;

use Arx\classes\Utils;

class EloquentModel extends ParentClass {

    /**
     * Define field which can be a json
     *
     * @var array
     */
    protected static $jsonable = array();

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $model = self::forceJsonable($model);
        });

        static::updating(function($model)
        {
            $model = self::forceJsonable($model);
        });
    }

    public static function forceJsonable($model){

        foreach($model::$jsonable as $key){
            if(is_array($model->{$key})){
                $model->{$key} = json_encode($model->{$key});
            }
        }

        return $model;
    }

    /**
     * Decode JsonModel
     *
     * @return $this
     */
    public function decodeJson(){

        foreach(self::$jsonable as $key){

            if(isset($this->{$key}) && Utils::isJson($$this->{$key})){
                $this->{$key} = json_decode($this->{$key});
            }
        }

        return $this;
    }

    /**
     * Transform to Array even Data encoded
     *
     * @return array
     */
    public function toArrayAll()
    {
        $data = $this->toArray();

        foreach(self::$jsonable as $key){

            if(isset($data[$key]) && Utils::isJson($data[$key])){
                $data[$key] = json_decode($this->{$key});
            }
        }

        return $data;
    }

} 