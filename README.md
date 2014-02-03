# Arx Core v. 4.1

[![Latest Stable Version](https://poser.pugx.org/arx/core/v/stable.png)](https://packagist.org/packages/arx/core) [![Total Downloads](https://poser.pugx.org/arx/core/downloads.png)](https://packagist.org/packages/arx/core) [![Latest Unstable Version](https://poser.pugx.org/arx/core/v/unstable.png)](https://packagist.org/packages/arx/core)

Arx core is the base of the Arx structure. It enhance some missing Laravel classes and tends to use Laravel on every kind of project like Wordpress, Drupal, Prestashop or custom structure (not totally implemented).

## Philosophy

Our philosophy is not to reinvented the wheel just pimp it with some missing classes, extensions, autoconfig or features that lacks in Laravel. We also add some defaults controllers, views, models structure that you can use or extends easily in your project even if it's not a Laravel project !

# Getting Started

## 1. Install Composer

Arx uses Composer to manage its dependencies. First, download a copy of the composer.phar. Once you have the PHAR archive, you can either keep it in your local project directory or move to usr/local/bin to use it globally on your system. On Windows, you can use the Composer Windows installer.

For more information about Composer [http://www.getcomposer.org](http://www.getcomposer.org)

# Install Arx-core only

Install Composer on your project root put then :

    composer require arx/core

or
    "arx-core" : "4.1.*"
to your composer.json file then run

    composer install or update

# How to contribute ?

You can contribute to the Arx project here :

[https://github.com/cherrylabs/arx/issues](https://github.com/cherrylabs/arx/issues)

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
