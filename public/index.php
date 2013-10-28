<?php

require __DIR__.'/../../../../vendor/autoload.php';

$app = new arx();

$app->bootstrap();

$app->run();

$app->shutdown();