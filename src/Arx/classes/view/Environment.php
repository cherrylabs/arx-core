<?php namespace Arx\classes\view;

use Illuminate\View\Environment as ParentClass;

class Environment extends ParentClass{
    protected $extensions = array('blade.php' => 'blade', 'tpl.php' => 'tpl', 'mustache.php' => 'mustache', 'twig.php' => 'twig', 'php' => 'php');
}