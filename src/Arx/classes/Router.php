<?php namespace Arx\classes;

use Illuminate\Routing\Router as ParentClass;

class Router extends ParentClass {


    public function run()
    {
        $aArgs = func_get_args();
        $iArgs = func_num_args();

        $request = new Request();

        if( isset($aArgs[0]) && is_object($aArgs[0]) ){
            $request = $aArgs[0];
        }

        echo $this->dispatch($request)->getContent();
    }
}
