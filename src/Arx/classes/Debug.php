<?php namespace Arx\classes;

use DebugBar\StandardDebugBar;

/**
 * Class Debug handler
 *
 * extends the DebugBar\StandardDebugBar class
 *
 * @todo method according PSR-3 LOGcompos
 * @package Arx\classes
 */
class Debug extends Singleton
{
    public function __construct(){
        if( class_exists('\Debugbar') ){
               return App::make('Debugbar');
        } else {
            return new StandardDebugBar();
        }
    }

} // class::Debug
