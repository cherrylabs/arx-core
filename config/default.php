<?php

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

if(is_file(ROOT_DIR.DS.'app/config/app.php')){

    require ROOT_DIR.'/bootstrap/autoload.php';

    /*
    |--------------------------------------------------------------------------
    | Turn On The Lights
    |--------------------------------------------------------------------------
    |
    | We need to illuminate PHP development, so let's turn on the lights.
    | This bootstrap the framework and gets it ready for use, then it
    | will load up this application so that we can run it and send
    | the responses back to the browser and delight these users.
    |
    */

    $app = require_once ROOT_DIR.'/bootstrap/start.php';

    $config = include ROOT_DIR.DS.'app/config/app.php';

    $config['system']['app'] = 'Arx\c_app';
    $config['system']['route'] = 'Arx\c_route';
    $config['system']['template'] = 'Arx\c_template';
    $config['system']['auth'] = 'Arx\c_auth';
    $config['system']['db'] = 'Arx\c_db';

    return $config;

} else {

    $config = array();

    $config['system']['app'] = 'Arx\c_app';
    $config['system']['route'] = 'Arx\c_route';
    $config['system']['template'] = 'Arx\c_template';
    $config['system']['auth'] = 'Arx\c_auth';
    $config['system']['db'] = 'Arx\a_db';

    return $config;
}