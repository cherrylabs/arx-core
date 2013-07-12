<?php namespace Arx\classes;

class View {
    public static function make($file, $data){
        extract($data);

        ob_start();
            include( __DIR__.'/../views/'.$file.'.php');
            $content = ob_get_contents();
        ob_flush();
    }
}