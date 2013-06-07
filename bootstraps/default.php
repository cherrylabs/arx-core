<?php

global $app;

// Using the Ruby pattern for routing (example of default using)
global $app;

$app = new arx();

$app->route->notFound(function() use ($app){

    $req = $app->route->request();

    //Get root URI
    $rootUri = $req->getRootUri();

    //Get resource URI
    $resourceUri = $req->getResourceUri();

    $aArgs = explode('/', substr($rootUri.$resourceUri, 1));

    $iArgs = count($aArgs);
    
    if($iArgs < 3){
        $aArgs[2] = 'index';
        if($iArgs < 2 || empty($aArgs[1])){
            $aArgs[1] = 'index';
            if($iArgs < 1){
                $aArgs[0] = $req->getResourceUri();
            }
        }
    }

    foreach ($aArgs as $key => $value) {
        if(!empty($value)){
            if($key == 0){
                $application = $app->_application = $value;
            } elseif($key == 1) {
                $controller = $app->_controller = $value;
            } elseif($key == 2) {
                $action = $app->_action = $value;
            } else {
                $aParam[] = $value;
            }
        }
    }

    //predie($aArgs);

    //Check if there is an app folder
    define('THIS_URL', URL_ROOT.'/'.$application);
    define('THIS_ROOT', DIR_ROOT.'/'.$application);
    define('THIS_DIR', '/'.$application.'/');



    //CHECK if there is a controller for the apps
    if ( is_file(THIS_ROOT.DS.CTRL.DS.$controller.PHP) ) {
        require_once THIS_ROOT.DS.CTRL.DS.$controller.PHP;
    } elseif ( is_file(THIS_ROOT.DS.'index'.PHP) ) {
        require_once THIS_ROOT.DS.'index'.PHP;
    }

    //CHECK if a class ctrl exist
    
    $classController = CTRL_.$controller;

    //CHECK if there is a js controller then we autoload the JS
    if (is_file(THIS_ROOT.DS.JS.DS.$controller.'.js')) {
        c_hook::js( THIS_URL.'/'.JS.'/'.$controller.'.js');
    }

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

        // Check if there is a views for the controller (if not by default html5 tpl)
        if (is_file(APP_ROOT.DS.VIEWS.DS.$controller.TPL)) {
            $app_controller->display(APP_ROOT.DS.VIEWS.DS.$controller.TPL);
        } elseif (is_file(APP_ROOT.DS.VIEWS.DS.'html'.TPL)) {

            if( ! $app_controller->content && is_file(APP_ROOT.DS.VIEWS.DS.$controller.'-'.$action.TPL)){
                $app_controller->content($controller.'-'.$action);
            } elseif (! $app_controller->content && is_file(APP_ROOT.DS.VIEWS.DS.$controller.'-'.'index'.TPL)) {
                $app_controller->content($controller.'-'.'index');
            }

            $app_controller->display(APP_ROOT.DS.VIEWS.DS.'html'.TPL);
        } elseif (is_file(ARX_VIEWS.DS.'html'.TPL)) {
            $app_controller->display(ARX_VIEWS.DS.'html'.TPL);
        }

    }

    // Check if there is a views for the controller (if not by default html5 tpl)
    if (is_file(APP_ROOT.DS.VIEWS.DS.$controller.TPL)) {
        $app->display(APP_ROOT.DS.VIEWS.DS.$controller.TPL);
    } elseif (is_file(APP_ROOT.DS.VIEWS.DS.'html'.TPL)) {
        $app->display(APP_ROOT.DS.VIEWS.DS.'html'.TPL);
    } elseif (is_file(ARX_VIEWS.DS.'html'.TPL)) {
        $app->display(ARX_VIEWS.DS.'html'.TPL);
    } else { //if app no exist
        $app->route->halt(404);
        exit();
    } 

});