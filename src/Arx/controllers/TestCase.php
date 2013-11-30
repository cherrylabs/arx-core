<?php namespace Arx\controllers;

/**
 * Class TestCase
 *
 * extends functions for Unit Testing
 *
 * @package Arx\controllers
 */
class TestCase extends \Illuminate\Foundation\Testing\TestCase {

    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require_once __DIR__.'/../bootstrap/default.php';
    }

}