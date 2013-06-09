<?php

$aClassAliases = array(

);

foreach ($aClassAliases as $original  => $alias) {
    class_alias($original, $alias);
}


$aFunctionAliases = array(
    'arxConfig' => '\Arx\c_config::get',
);

foreach ($aFunctionAliases as $aliasName => $callback) {
    \Arx\u::alias($aliasName, $callback);
}


