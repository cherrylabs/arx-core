<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new Arx();

predie($app);

$app->get('/', function() use ($app){
    $app->content(__('hello'));
    $app->display('index');
});

$app->run();
