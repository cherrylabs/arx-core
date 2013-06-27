<?php

$aClassAliases = array(

);

foreach ($aClassAliases as $aliasName  => $class) {
    class_alias($class, $aliasName);
}


$aFunctionAliases = array(
    'arxConfig' => '\Arx\classes\Config::getInstance',
    'gConfig' => '\Arx\classes\Config::get',
    'sConfig' => '\Arx\classes\Config::set',

);

foreach ($aFunctionAliases as $aliasName => $callback) {
    \Arx\u::alias($aliasName, $callback);
}


