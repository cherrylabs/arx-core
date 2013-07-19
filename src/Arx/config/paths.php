<?php
// --- Paths configuration

return array(
    'classes'   => realpath(__DIR__.'/../classes'),
    'config'    => realpath(__DIR__.'/../config'),
    'arx'       => realpath(__DIR__.'/..'),
    'root'      => getenv('DOCUMENT_ROOT'),
    'rooturl'   => HTTP.getenv('HTTP_HOST'),
    'app'       => getenv('DOCUMENT_ROOT').DIRECTORY_SEPARATOR.'app',
    'controllers'       => getenv('DOCUMENT_ROOT').DIRECTORY_SEPARATOR.'app/controllers',
    'models'       => getenv('DOCUMENT_ROOT').DIRECTORY_SEPARATOR.'app/models',
    'views'       => getenv('DOCUMENT_ROOT').DIRECTORY_SEPARATOR.'app/views',
);
