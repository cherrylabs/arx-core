<?php namespace Arx;

use Response;

trait controllerApiTrait
{
    public $statusCode;
    
    public function getStatusCode(){
        return $this->statusCode;
    }

    public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
    }

    public function respondNotFound($message  = 'not found'){
        return Response::json([
            'errors' => [

            ],
            'code' => $this->getStatusCode(),
            'msg' => $message
        ]);
    }
}