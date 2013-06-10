<?php

$aClassAliases = array(
    'arx\\arx' => '\Arx',
    'c_hook' => '\arx\c_hook'
);

foreach ($aClassAliases as $aliasName  => $class) {
    class_alias($class, $aliasName);
}


$aFunctionAliases = array(
    'arxConfig' => '\Arx\c_config::get',
);

foreach ($aFunctionAliases as $aliasName => $callback) {
    \Arx\u::alias($aliasName, $callback);
}


