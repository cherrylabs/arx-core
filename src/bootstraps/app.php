<?php

global $app;

$app->route->map('/:app(/:controller)(/:action)(/:param1)(/:param2)(/:param3)(/:param4)(/:param5)(/:param6)', function() use ($app) {

    $aArgs = func_get_args();
    $iArgs = func_num_args();

    $aParam = array();

    //predie($aArgs);

    foreach ($aArgs as $key => $value) {
        if($key == 0){
            $application = $app->_application = $value;
        } elseif($key == 1)	{
            $controller = $app->_controller = $value;
        } elseif($key == 2)	{
            $action = $app->_action = $value;
        } else {
            $aParam[] = $value;
        }
    }

    //charging index controller by default

    if(empty($controller)){
        $controller = 'index';
    }


    //CHANGE DIR PATH => RELATIVE TO THE APP FOLDER NOW !! PAID ATTENTION

    if (is_dir(dirname(__FILE__).DS.$application)) {

        define('APP_URL', URL_ROOT.'/'.APPS.'/'.$application);
        define('APP_ROOT', dirname(__FILE__).DS.$application);
        define('APP_DIR', '/'.$application.'/');

        define('ROOT_PATH', APP_ROOT);
        define('BASE_URL', APP_URL);

        chdir(dirname(__FILE__).DS.$application);

    }

    //Check if there is a core php for the app
    if ( is_file(APP_ROOT.DS.'config'.PHP) ) {
        require_once APP_ROOT.DS.'config'.PHP;
    }

    //CHECK if there is a controller for the apps
    if ( is_file(APP_ROOT.DS.CTRL.DS.$controller.PHP) ) {
        require_once APP_ROOT.DS.CTRL.DS.$controller.PHP;
    } elseif ( is_file(APP_ROOT.DS.'index'.PHP) ) {
        require_once APP_ROOT.DS.'index'.PHP;
    }

    //CHECK if there is a js controller then we autoload the JS
    if (is_file(APP_ROOT.DS.JS.DS.$controller.'.js')) {
        c_hook::js( APP_URL.'/'.JS.'/'.$controller.'.js');
    }

    //CHECK if a class ctrl exist
    
    $classController = CTRL_.$controller;

    if (class_exists($classController)) {

        $app_controller = new $classController($app);

        switch ($iArgs) {
            # case /app/
            case 1:
            case 2:
                call_user_func(array($app_controller, 'index'));
                break;

            # case /app/controller/function
            case 3:
                call_user_func(array($app_controller, $app->_action));
                break;
            
            default:
                call_user_func_array(array($app_controller, $app->_action), $aParam);
                break;
        }
    } else {
        // Check if there is a views for the controller (if not by default html5 tpl)
        if (is_file(APP_ROOT.DS.VIEWS.DS.$controller.TPL)) {
            $app->display(APP_ROOT.DS.VIEWS.DS.$controller.TPL);
        } elseif (is_file(APP_ROOT.DS.VIEWS.DS.'html5'.TPL)) {
            $app->display(APP_ROOT.DS.VIEWS.DS.'html5'.TPL);
        } elseif (is_file(ARX_VIEWS.DS.'html5'.TPL)) {
            $app->display(ARX_VIEWS.DS.'html5'.TPL);
        }
    }

})->via('GET','POST','DELETE','PUT');
