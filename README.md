# Arx Core v.1.0 (alpha release)

[![Latest Stable Version](https://poser.pugx.org/arx/core/v/stable.png)](https://packagist.org/packages/arx/core) [![Total Downloads](https://poser.pugx.org/arx/core/downloads.png)](https://packagist.org/packages/arx/core) [![Latest Unstable Version](https://poser.pugx.org/arx/core/v/unstable.png)](https://packagist.org/packages/arx/core)

Arx core is the base of the Arx structure. It enhance some missing Laravel classes and tends to use Laravel on every kind of project like Wordpress, Drupal, Prestashop or custom structure (not totally implemented).

## Philosophy

Our philosophy is not to reinvented the wheel just pimp it with some missing classes, extensions or features that lacks in Laravel. We also add some defaults controllers, views, models structure that you can include and extend easily in your Laravel project.

# Getting Started

## Install Composer

Arx utilizes Composer to manage its dependencies. First, download a copy of the composer.phar. Once you have the PHAR archive, you can either keep it in your local project directory or move to usr/local/bin to use it globally on your system. On Windows, you can use the Composer Windows installer.

For more information about Composer

# Install Arx-core only

add "arx-core" : "*" to your composer.json file then run

composer install or update

# What's new ? :

## v.1.0 (alpha) Features

- allow to use a different structure than default Laravel structure => instead to call in public/index.php ../bootstrap/start.php => just require ../vendor/autoload.php then $app = new arx() (so know you can work in another structure than Laravel by default)
- add some useful classes like Utils class (for better getJson, little template engine, Dummy class (image, text, video generator) for development etc.
- add Hash class to people that can't install mcrypt extension or is under PHP 5.3.7
- add possibility to have directly a facade function with resolve functions
- add Bootstrap layouts template for fast prototyping (see {vendor/workbench}/arx/core/src/views for more informations about available templates)

For the complete features : [check the documentation](http://www.arx.io/docs/arx/core)
