<?php
// --- System configuration

return array(
    'cache'  => '\\Arx\\classes\\Cache',
    'debug' => '\\Arx\\classes\\Debug',
    'orm' => array('\\Arx\\classes\\Orm', 'database'),
    'router' => '\\Arx\\classes\\Router',
    'view' => '\\Arx\\classes\\View'
);
