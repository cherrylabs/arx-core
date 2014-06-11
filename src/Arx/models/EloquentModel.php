<?php namespace Arx;

use Illuminate\Database\Eloquent\Model as ParentClass;

use Arx\classes\Utils;
use DB;

class EloquentModel extends ParentClass {

    /**
     * Define fields which can be a json
     *
     * @var array
     */
    protected static $jsonable = array();

    private static $_aInstances = array();

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $model = $model->forceJsonable($model);
        });

        static::updating(function($model)
        {
            $model = $model->forceJsonable($model);
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
    public function decodeJson($assoc = false){

        foreach(self::$jsonable as $key){

            if(isset($this->{$key}) && Utils::isJson($$this->{$key})){
                $this->{$key} = json_decode($this->{$key}, $assoc);
            }
        }

        return $this;
    }

    /**
     * Transform to Array even Json Data encoded
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

    public static function getInstance(){
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }

    /**
     * Get Structure of the current table
     *
     * @param bool $withGuarded
     * @param bool $asKey
     * @return array
     * @throws \Exception
     */
    public static function getStructure($withGuarded = false, $asKey = false)
    {
        $t = new self;

        $table = $t->getTable();

        switch (DB::connection()->getConfig('driver')) {
            case 'pgsql':
                $query = "SELECT column_name FROM information_schema.columns WHERE table_name = '".$table."'";
                $column_name = 'column_name';
                $reverse = true;
                break;

            case 'mysql':
                $query = 'SHOW COLUMNS FROM '.$table;
                $column_name = 'Field';
                $reverse = false;
                break;

            case 'sqlsrv':
                $parts = explode('.', $table);
                $num = (count($parts) - 1);
                $table = $parts[$num];
                $query = "SELECT column_name FROM ".DB::connection()->getConfig('database').".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'".$table."'";
                $column_name = 'column_name';
                $reverse = false;
                break;

            default:
                $error = 'Database driver not supported: '.DB::connection()->getConfig('driver');
                throw new \Exception($error);
                break;
        }

        $columns = array();

        foreach(DB::select($query) as $column)
        {
            $columns[] = $column->$column_name;
        }

        if($reverse)
        {
            $columns = array_reverse($columns);
        }

        if($withGuarded){

            $kColumns = array_flip($columns);

            foreach($t->guarded as $key){

                if(isset($kColumns[$key])){

                    unset($columns[$kColumns[$key]]);
                }
            }

            # Switch keys if we want column name as key
            if($asKey)
            {
                $columns = array_flip($columns);
            }

            # remove timestamp

            $updated_at = array_search('updated_at', $columns);

            if($updated_at !== false){
                unset($columns['updated_at']);
            }

            $created_at = array_search('created_at', $columns);

            if($created_at !== false){
                unset($columns['created_at']);
            }

        }

        return $columns;
    }

} 