<?php

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

$config = array();

if(is_file(ROOT_DIR.DS.'arxConfig.php')){

} else {

}

$config['system']['app'] = 'Arx\c_app';
$config['system']['route'] = 'Arx\c_route';
$config['system']['template'] = 'Arx\c_template';
$config['system']['auth'] = 'Arx\c_auth';
$config['system']['db'] = 'Arx\a_db';

return $config;