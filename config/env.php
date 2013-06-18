<?php

return array(
    "local" => preg_match("/localhost|loc/", $_SERVER['SERVER_NAME']),
    "dev" => preg_match("/dev./i", $_SERVER['SERVER_NAME']),
    "demo" => preg_match("/demo./i", $_SERVER['SERVER_NAME']),
    "www" => preg_match("/www./i", $_SERVER['SERVER_NAME']),
);