# Arx Core v. 4.1

[![Latest Stable Version](https://poser.pugx.org/arx/core/v/stable.png)](https://packagist.org/packages/arx/core) [![Total Downloads](https://poser.pugx.org/arx/core/downloads.png)](https://packagist.org/packages/arx/core) [![Latest Unstable Version](https://poser.pugx.org/arx/core/v/unstable.png)](https://packagist.org/packages/arx/core)

Arx core is the base of the [Arx project](http://www.arx.io). It gives some usefull classes, templates, assets for Laravel but some classes are usable in every kind of project like Wordpress, Drupal, Prestashop or your custom structure !

# Getting Started

## 1. Install Composer (skip this if you know it)

Arx uses Composer to manage its dependencies. First, download a copy of the composer.phar. Once you have the PHAR archive, you can either keep it in your local project directory or move to usr/local/bin to use it globally on your system. On Windows, you can use the Composer Windows installer.

For more information about Composer [http://www.getcomposer.org](http://www.getcomposer.org)

# Install Arx-core only

Install Composer on your project root put then :

    php composer.phar require arx/core

or in your composer.json file

    "arx-core" : "dev-master"

    php composer.phar install or update

# How to use it ?

In your php file, add : 

    require '{your_project_path}/vendors/autoload.php';

Now you can access to the Arx namespace referring to '/vendor/arx/core/src/Arx', that's it !

## 1. Enabling debug helpers functions

If you want you can enable debug helpers functions with

    Arx::ignite();

This will give you a better debug view than classic var_dump adding function (only if they doesn't exist) : 
    
    d(xx) function make a better var_dump with the time and the line of code where it's called
    dd(xx) do the same with a die at the end
    k(); => will output a die with execution time info and the line of code where it's called

## 2. How to use Arx classes ?

To use an arx class, simply refer to the files starting with the Arx namespace.

Example : 

Arx\classes\Utils => refers to /vendor/arx/core/src/Arx/classes/Utils.php
Arx\classes\Dummy => refers to /vendor/arx/core/src/Arx/classes/Dummy.php
Arx\helpers\Bootstrap => refers to /vendor/arx/core/src/Arx/helpers/Bootstrap.php etc...

You can also make a reference in your php like this : 

    <?php
    
    require '{your_project_path}/vendor/autoload.php';
    
    use Arx\classes\Dummy; // this will create a class alias Dummy refering to Arx\classes\Dummy
    use Arx\classes\Utils as u; // this will create a class alias u refering to Arx\classes\Utils
    use Arx\classes\Arr; // You can add as much class as your want
    
    $test = array(
            'content' =>  Dummy::text(256), // => generate a dummy text of 256 character
            'image' =>  Dummy::image('400x300'), // => generate a dummy image link of 400x300
            'email' =>  u::randEmail(), // => generate a random email
            );
    
    u::jsonDie($test); // refers to Arx\classes\Utils.php @ method jsonDie will output a json with the array


For a complete list of available classes in Arx : 

Please see : https://github.com/cherrylabs/arx-core/tree/master/src/Arx/classes


# How to contribute ?

Some classes are missing documentation or still buggy => don't hesitate to fix this !

You can contribute to the Arx project here :

[https://github.com/cherrylabs/arx/issues](https://github.com/cherrylabs/arx/issues)

You can also contribute directly in your project if you want by pushing directly to the Git repos !

To make this : just checkout this repository inside : workbench/arx/core folder then add to your composer.json this :

    "require": {
        "php": ">=5.3.2",
        "laravel/laravel": "4.1.x",
        "kriswallsmith/assetic" : "*"
    },
    "require-dev": {
        "phpunit/phpunit": "3.7.*",
        "mockery/mockery": "0.7.2"
    },
    "autoload": {
        "psr-0": {
            "Arx": "workbench/arx/core/src"
        },
        "files" : ["workbench/arx/core/src/Arx/core.php"]
    },

# What's new ? :

## 4.1.x

- Compatibility with Laravel 4.1
- Documentation has moved to his own repository for better download performance
- The version will follows the Laravel version number to avoid complications so we skip the 3 version !
- Config classes from Arx are now usable outside Laravel ! Just call new Arx\classes\Config() see

## 3.x

- Skipped to follow Laravel Version conventions ! (see above)

## 2.3.x

- Compatibility with Laravel 4.0

## 2.x (beta) Features

- Improve compatibility add somes functions

## 1.0.x (alpha) Features

- allow to use a different structure than default Laravel structure => instead to call in public/index.php ../bootstrap/start.php => just require ../vendor/autoload.php then $app = new arx() (so know you can work in another structure than Laravel by default)
- add some useful classes like Utils class (for better getJson, little template engine, Dummy class (image, text, video generator) for development etc.
- add Hash class to people that can't install mcrypt extension or is under PHP 5.3.7
- add possibility to have directly a facade function with resolve functions
- add Bootstrap layouts template for fast prototyping (see {vendor/workbench}/arx/core/src/views for more informations about available templates)

For the complete features : [check the documentation](http://www.arx.io/docs)
