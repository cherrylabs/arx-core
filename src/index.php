<?php

require __DIR__.'/../vendor/autoload.php';


$app = new \Arx\classes\App();


u::pre('test');

die(var_dump(get_included_files()));

echo 'ok';
