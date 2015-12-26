# Arx Core v. 5.2

[![Latest Stable Version](https://poser.pugx.org/arx/core/v/stable.svg)](https://packagist.org/packages/arx/core) [![Total Downloads](https://poser.pugx.org/arx/core/downloads.svg)](https://packagist.org/packages/arx/core) [![Latest Unstable Version](https://poser.pugx.org/arx/core/v/unstable.svg)](https://packagist.org/packages/arx/core) [![License](https://poser.pugx.org/arx/core/license.svg)](https://packagist.org/packages/arx/core)

Arx Core is a library tools for PHP and Laravel giving some usefull classes, traits, and resources to help you build awesome PHP Projects.

It is highly maintened by a [dedicated agency](http://www.cherrypulp.com), so don't hesitate to make your comments or bug fixes.

# 1. Getting Started

## 1.1 Install via Composer

For more information about Composer [http://www.getcomposer.org](http://www.getcomposer.org)

Install Composer on your project root put then :

````bash
    composer require arx/core=5.2.x
````

or add in your existing composer.json file add this in the require

````json
    "require": {
        "[...]",
        "arx/core":"5.2.x"
    },
````

Then you can access to the Arx kit in your PHP project (if you require_once /vendor/autoload.php).

## 1.2 Install in Laravel

In your Laravel project, just add this in your config/app.php

````php
    'providers' => [
        [...],
        \Arx\CoreServiceProvider::class
    ]
````
It will autoload, some usefull Facades, and providers for Laravel behind the scenes. See the CoreServiceProvider class for a listing.

## 1.3 Install only one file class (only what you need)

You can by the way only download what you need. We try to do our best to make every class usable as stand-alone.

Example : 

````bash
curl -O https://raw.githubusercontent.com/cherrylabs/arx-core/master/src/Arx/classes/Str.php
````

[More info here](https://github.com/cherrylabs/arx-core/wiki/Stand-alone-script)

## 3. Structure and philosophy

The structure and the philosophy behind Arx are "Keep It Simple Stupid" and "Don't Reinvent the Wheel".

There are some classes and flows that you might uses in any kind of Php project - so why reinvent the wheel ?

### Arx/classes (for any kind of Php Project)

This folder contains some usefull classes that you might use in your PHP project. Example : an Image Class, a Dummy generator, some String Helpers, a Markdown reader etc.

### Arx/commands (for Laravel)

This will add some command in your Laravel Project like an ES6 Js Generator.

### Arx/controllers (for Laravel)

This is some usefull Laravel Controller for handling routing protection, or improve your default BaseController.

### Arx/facades (for Laravel)

This folder contains Facade design pattern class, typically they're the class that can be called statically but refers to an instanciated class inside the App constructor classes (like in Laravel Route class, Auth, Mail etc...).

We've added a little resolver helper method so you can manipulate data before sending to the facadeAccessor or simply give the ability to have information to the method with Code Intelligence.

Example : 

    <?php namespace Arx\facades;
    
    use Arx\classes\Facade;
    
    class Config extends Facade{
    
    /**
     * Get the specified configuration value.
     *
     * @param string  $key
     * @param mixed   $default
     * @return mixed
     * @static
     */
    public static function get($key, $default = null)
    {
        // here you can manipulate the variable before resolve this with the Facade Accessor
        return self::resolve($key, $default = null);
    }
    
    /**
     * Get the registered name of the component instanciate by the app
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'config'; }
    }

### Arx/helpers (PHP and Laravel)

Contains some class Helpers for HTML construct (like Bootstrap structure helper) => W.I.P.


### Arx/interfaces (PHP)

Contains some Interface that you might use in your project to ensure that is standard.

### Arx/middlewares (Laravel)

Middlewares that you might use in your Laravel project.

### Arx/models (PHP/Laravel)

Some model that you might reuse in your Php Project.

### 3.5 Arx/providers

Define Service providers class, provided by Arx/core

### 3.6 Arx/traits

Contains some traits that you can use in your project (/!\ > 5.4 only !)

## 4. Using default bootstrap starter views 

For fast page prototyping in a Laravel project, we have also included some usefull default HTML template and assets to build quickly a prototype page (typically the default bootstrap example pages) or a page for your package documentation.

To use it, first with need to copy paste the assets to the public folder => in command line you can do this : 

    php artisan assets:publish arx/core
    # or if arx/core is in the workbench
    php artisan assets:publish --bench=arx/core
    

in your Laravel views :

    @extends('arx::layouts.bootstrap')
    
    @section('content')
        Your CONTENT !
    @stop
    
    @section('css')
        @parent
        <link href="{YOUR CUSTOM CSS}" rel="stylesheet">
    @stop
    
    @section('js')
        @parent
        <script src="xxxyour other scripts"></script>
    @stop
    
/!\ The template use our "Temple Engine" which is almost the same than Blade engine, the only differences are : 
- the extension file is tpl.php instead of blade.php (better standard outside laravel)
- we use <% %> instead of {{ }} to avoid any conflicts with Angular, Mustache or other javascript engine and also because with <% %> it will proper considered as PHP script in your editor like PHPStorm or Sublime Text :-)

# How to contribute ?

Some classes are missing documentation or still buggy => so don't hesitate to fix this to help us !

You can contribute to the Arx project here by posting your bugs, suggestions, ideas here :

[https://github.com/cherrylabs/arx/issues](https://github.com/cherrylabs/arx/issues)

You can also contribute directly in your project if you want by pushing directly to the Git repos !

To use Arx directly from the repo just checkout this repository inside a workbench/arx/core folder then add to your composer.json this configuration :

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

## 4.2 :

- remove 5.3 compatibility to use Trait like in Laravel 4.2
- Request and Validator class is now available outside Laravel !
- add a Hook class

## 4.1.5 :

- introduce Arx Command Line Interface ! New Command will come soon...
- add Grunt generator for Laravel now you can generate a grunt file with

    artisan arx:gen grunt

- add a better Command:make for workbench (auto resolve with --path autoresolve function and --namespace auto resolve
- move Arx\classes\View to Arx/providers/ViewServiceProvider.php and clean some View logic so now the class View can be usable outside a Laravel Project (still W.I.P)
- clean some class with scruttinizer

## 4.1.x

- Compatibility with Laravel 4.1
- Documentation has moved to his own repository for better download performance
- The version will follows the Laravel version number to avoid complications so we skip the 3 version !
- Config classes from Arx are now usable outside Laravel ! Just call new Arx\classes\Config()
- Database class from Laravel are now available outside Laravel
- Add a Mail class helper from laravel and SwiftMailer usable outside Laravel too !

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
