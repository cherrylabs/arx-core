<?php
// --- Aliases configuration

return array(
    'classes' => array(
        'App' => '\Arx\classes\App',
        'Arrays' => '\Arx\classes\Arrays',
        'Assets' => '\Arx\classes\Assets',
        'Config' => '\Arx\classes\Config',
        'Date' => '\Arx\classes\Date',
        'Finder' => '\Arx\classes\Finder',
        'Globals' => '\Arx\classes\Globals',
        'Hook' => '\Arx\classes\Hook',
        'Singleton' => '\Arx\classes\Singleton',
        'Utils' => '\Arx\classes\Utils',
        'Valid' => '\Arx\classes\Valid',
        'u' => '\Arx\classes\Utils',
    ),
    'functions' => array(
        'arxConfig' => '\Arx\classes\Config::getInstance',
        'getConfig' => '\Arx\classes\Config::get',
        'setConfig' => '\Arx\classes\Config::set',
        'predie' => '\Arx\classes\Utils::predie',
        'pre' => '\Arx\classes\Utils::pre',
        'k' => '\Arx\classes\Utils::k',
    ),
);
