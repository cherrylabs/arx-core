<?php

require __DIR__.'/../vendor/autoload.php';

\Arx\classes\Debug::dump('test', array('test', 3, new StdClass()));

$app = new \Arx\classes\App();


//$app->get('/', function() use ($app){
//    $app->content(__('hello'));
//    $app->display('index');
//});
//
//$app->run();
