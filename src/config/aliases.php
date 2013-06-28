<?php
// --- Database configuration

return array(
    'classes' => array(
        'Arx' => '\Arx\classes\App',
        'Config' => '\Arx\classes\Config',
        'Utils' => '\Arx\classes\Utils',
    ),
    'functions' => array(
        'arxConfig' => '\Arx\classes\Config::getInstance',
        'getConfig' => '\Arx\classes\Config::get',
        'setConfig' => '\Arx\classes\Config::set',
    ),
);
