<?php

$config = array();

if( is_file(ROOT_DIR.DS.'arxConfig.php') ){
    $config = include_once ROOT_DIR.DS.'arxConfig.php';
} else {
    $config['system']['app'] = '\Arx\c_app';
    $config['system']['route'] = '\Arx\c_route';
    $config['system']['template'] = '\Arx\c_template';
    $config['system']['auth'] = '\Arx\c_auth';
    $config['system']['db'] = '\Arx\a_db';
    $config["env"] = "default";
    $config["mode"] = "dev";
}

return $config;