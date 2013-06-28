<?php
// --- Aliases configuration

return array(
    'classes' => array(
        'App' => '\Arx\classes\App',
        'Arrays' => '\Arx\classes\Arrays',
        'Assets' => '\Arx\classes\Assets',
        'Config' => '\Arx\classes\Config',
        'Date' => '\Arx\classes\Date',
        'Filemanager' => '\Arx\classes\Filemanager',
        'Globals' => '\Arx\classes\Globals',
        'Hook' => '\Arx\classes\Hook',
        'Singleton' => '\Arx\classes\Singleton',
        'Utils' => '\Arx\classes\Utils',
        'Validate' => '\Arx\classes\Validate',
    ),
    'functions' => array(
        'arxConfig' => '\Arx\classes\Config::getInstance',
        'getConfig' => '\Arx\classes\Config::get',
        'setConfig' => '\Arx\classes\Config::set',
    ),
);
