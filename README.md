# Arx Core v. 4.1

[![Latest Stable Version](https://poser.pugx.org/arx/core/v/stable.svg)](https://packagist.org/packages/arx/core) [![Total Downloads](https://poser.pugx.org/arx/core/downloads.svg)](https://packagist.org/packages/arx/core) [![Latest Unstable Version](https://poser.pugx.org/arx/core/v/unstable.svg)](https://packagist.org/packages/arx/core) [![License](https://poser.pugx.org/arx/core/license.svg)](https://packagist.org/packages/arx/core)

Arx core is the base of the [Arx project](http://www.arx.io). It gives some usefull classes, templates, assets for Laravel but some classes are usable in every kind of project like Wordpress, Drupal, Prestashop or even your custom PHP project !

It is highly maintened by a [dedicated agency](http://www.cherrypulp.com), so don't hesitate to make your comments or bug fixes.

# Getting Started

## 1. Install Composer (skip this if you know how)

Arx uses Composer to manage its dependencies. First, download a copy of the composer.phar. Once you have the PHAR archive, you can either keep it in your local project directory or move to usr/local/bin to use it globally on your system. On Windows, you can use the Composer Windows installer.

For more information about Composer [http://www.getcomposer.org](http://www.getcomposer.org)

# Install Arx-core only

Install Composer on your project root put then :

    php composer.phar require arx/core

or add in your existing composer.json file

    "arx-core" : "dev-master"

    php composer.phar install or update

# Install only one file class

You can by the way only download what you need. We try to do our best to make every class usable as stand-alone.

Example : 

curl -O https://raw.githubusercontent.com/cherrylabs/arx-core/master/src/Arx/classes/Utils.php

curl -O https://raw.githubusercontent.com/cherrylabs/arx-core/master/src/Arx/classes/Image.php

curl -O https://raw.githubusercontent.com/cherrylabs/arx-core/master/src/Arx/classes/Arr.php

Unfortunately some classes need some dependencies that you have to include in your Composer.

# How to use it ?

In your php file, add : 

    require '{your_project_path}/vendors/autoload.php';

Now you can access to the Arx namespace referring to '/vendor/arx/core/src/Arx', that's it !

## 1. Enabling debug helpers functions

If you want you can enable debug helpers functions with

    Arx::ignite();

This will give you a better debug view than classic var_dump adding function (only if they doesn't exist) : 

    d($XXX); function make a better var_dump with the time and the line of code where it's called
    de($XXX); do the same with a die at the end
    k(); => will output a die with execution time info and the line of code where it's called

## 2. How to use Arx classes ?

To use an arx class, simply refer to the files starting with the Arx namespace.

Example : 

    Arx\classes\Utils => refers to /vendor/arx/core/src/Arx/classes/Utils.php
    Arx\classes\Dummy => refers to /vendor/arx/core/src/Arx/classes/Dummy.php
    Arx\classes\Image => refers to /vendor/arx/core/src/Arx/classes/Image.php
    Arx\helpers\Bootstrap => refers to /vendor/arx/core/src/Arx/helpers/Bootstrap.php etc...

You can also make a reference in your php file like this : 

    <?php
    
    require '{your_project_path}/vendor/autoload.php';
    
    use Arx\classes\Dummy; // this will create a class alias Dummy refering to Arx\classes\Dummy
    use Arx\classes\Utils as u; // this will create a class alias u refering to Arx\classes\Utils
    use Arx\classes\Arr; // You can add as much class as your want !
    
    $test = array(
            'content' =>  Dummy::text(256), // => generate a dummy text of 256 character
            'image' =>  Dummy::image('400x300'), // => generate a dummy image link of 400x300
            'email' =>  u::randEmail(), // => generate a random email
            );
    
    u::jsonDie($test); // refers to Arx\classes\Utils.php @ method jsonDie will output a json with the array


For a complete list of available classes in Arx go to : 
[Github link](https://github.com/cherrylabs/arx-core/tree/master/src/Arx/classes)

## 2.1 How to use Config class like in Laravel ?

The Config class works like in Laravel except that you need to load a folder to have the config example :

    <?php

        require_once __DIR__.'/vendor/autoload.php';
        
        use Arx\classes\Config;

        Arx::ignite();

        Config::load('{your config folder or file}');

        Config::get('yourarrayorfile.keyofarray');



## 2.2 How to use Laravel ORM class and Eloquent Model ?

The Db class wrap the beautiful Db and Eloquent Laravel class. To use it outside a Laravel project simply config the class with Arx\classes\Db::config({CONFIG LIKE IN LARAVEL}) :

    <?php

    require_once __DIR__.'/vendor/autoload.php';

    Arx::ignite();

    // Using Database

    use Arx\classes\Db;

    Db::config(
        array(
          'driver'    => 'mysql',
          'host'      => 'localhost',
          'database'  => 'database',
          'username'  => 'root',
          'password'  => '',
          'charset'   => 'utf8',
          'collation' => 'utf8_unicode_ci',
          'prefix'    => '',
        )
    );

    // Example of Table Schema creation
    if(!Db::schema()->hasTable('users')){
        Db::schema()->create('users', function($table){
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    // Example of EloquentModel
    class User extends Arx\EloquentModel {

    }

    $user = new User;

    // Generate a random email for demo
    $user->email = \Arx\classes\Utils::randEmail();

    $user->save();

    de(Db::table('users')->get());

## 2.3 How to use Mail class ?

The mail class works almost like in Laravel, you need to config the class before to use it :

    <?php

    require_once __DIR__.'/vendor/autoload.php';
    
    use Arx\classes\Mail;
    
    #1. Config the Mail class
    Mail::config(array(

        'driver' => 'smtp',

        'host' => 'in.mailjet.com',

        'port' => 587,

        'from' => array('address' => '{your_adress}', 'name' => '{your_name}'),

        'encryption' => 'tls',

        'username' => '{yourusername}',

        'password' => '{yourpassword}',

        'sendmail' => '/usr/sbin/sendmail -bs',

        'pretend' => false,

    ));
    
    # Send and email
    Mail::send(
        // Send message like the SwiftMessage : http://swiftmailer.org/docs/messages.html
        Mail::message()
        ->setFrom('test@{your url}.com', 'TEST')
        ->setTo(array('{your_EMAIL}'))
        ->setBody('TEST')
    );

## 3. How to use other folders ?

**/!\** The rest are for now **only available for a Laravel Project** but we are working hard to make it most 
compatible with other popular project like Wordpress, Drupal, Prestashop with their respective adapter package.
If you are starting a **new project**, you may want to **use our complete and ready to start package** including Laravel, Arx Core, Bootstrap, Font-Awesome, Bower and Grunt config and AngularJS.
    
=> **Go to our [Arx complete starter project](https://github.com/cherrylabs/arx)**

### 3.1 Arx/config

This folder contains some default and usually used config for Arx and Laravel project (example ide-helper generator, way generator, debugbar etc.). In your new project you can copy paste any configuration suggestion if you want or make a array_merge with config and your config.

### 3.2 Arx/controllers

This folder contains some usefull default controller for your project example : default asset controller, user controller etc. => /!\ it still in work in progress => don't hesitate to suggest your default controller or needs [here](https://github.com/cherrylabs/arx/issues).

### 3.3 Arx/facades

This folder contains Facade design pattern class, typically they're the class that can be called statically but refers to an instanciated class inside the App constructor classes (like in Laravel Route class, Auth, Mail etc...).

We've added a little resolver helper method so you can manipulate data before sending to the facadeAccessor or simply give the ability to have information to the method with CodeIntel.

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

### 3.4 Arx/helpers

Contains some class Helpers for HTML construct (like Bootstrap structure helper) => W.I.P.

### 3.5 Arx/providers

Define providers class according to Laravel and Symfony standards.

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
