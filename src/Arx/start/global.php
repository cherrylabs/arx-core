<?php

use Illuminate\Support\ClassLoader;

ClassLoader::addDirectories(array(
    realpath(dirname(__FILE__).'/../providers')
));