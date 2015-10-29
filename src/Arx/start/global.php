<?php

use Illuminate\Support\ClassLoader;

/**
 * Global autoload folders
 */
ClassLoader::addDirectories(array(
    realpath(dirname(__FILE__).'/../providers')
));