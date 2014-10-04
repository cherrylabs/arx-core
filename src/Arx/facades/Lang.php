<?php namespace Arx\facades;

use Arx\classes\Facade;
use Arx\classes\Arr;

class Lang extends Facade {
    /**
     * Merge functions
     *
     * @param $key
     * @param null $lang
     * @param $data
     * @return mixed
     */
    public static function merge($data = array(), $lang = null, $key = null){

        if(!$key){
            $bt =  debug_backtrace();
            $key = str_replace(array('.php'), '', basename($bt[0]['file']));
        }

        if(!$lang){

            $app = include app_path('config/app.php');

            $default = Lang::get($key, array(), $app['locale']);
        } else {
            $default = Lang::get($key, array(), $lang);
        }

        return Arr::overwrite($default, $data);
    }

    /**
     * Get the registered name of the component instanciate by the app
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'translator'; }

} 