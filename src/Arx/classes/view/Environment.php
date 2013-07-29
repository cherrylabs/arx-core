<?php namespace Arx\classes\view;

use Illuminate\View\Environment as ParentClass;

class Environment extends ParentClass{
    protected $extensions = array('blade.php' => 'blade', 'php' => 'php', 'tmpl.php' => 'tmpl', 'mustache.php' => 'mustache', 'twig.php' => 'twig');


}