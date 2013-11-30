<?php namespace Arx\classes\view;

use Illuminate\View\Environment as ParentClass;

/**
 * Class Environment
 *
 * Add support for tpl Engine and Twig, Mustache template (you need to add and resolve yourself the mother)
 *
 * @package Arx\classes\view
 */
class Environment extends ParentClass{
    protected $extensions = array('blade.php' => 'blade', 'tpl.php' => 'tpl', 'mustache.php' => 'mustache', 'twig.php' => 'twig', 'php' => 'php');
}