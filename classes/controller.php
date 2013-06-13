<?php namespace Arx;

class c_controller extends \Arx
{

    public function __construct( $mConfig = array() ){

        parent::__construct($mConfig);

        self::_init();

    }

    public function _init(){}

    public function __get($name){
        if($name == ('t')){
            return self::getInstance();
        }
    }


	public function ajax(){

		$iArgs = func_num_args();
		$aArgs = func_get_args();

		switch ($iArgs) {
			case 0:
				$response = false;
				break;

			case 1:
				$response = call_user_func(array($this, $aArgs[0]));
			break;
			
			default:
				$action = array_shift($aArgs);
				$response = call_user_func_array(array($this, $action), $aArgs);
				break;
		}

		u::json_die($response);
	}	

	public function debug(){
		if(ZE_LEVEL_ENV < 2){
			$iArgs = func_num_args();
			$aArgs = func_get_args();

			switch ($iArgs) {
				case 0:
					$response = false;
					break;

				case 1:
					$response = call_user_func(array($this, $aArgs[0]));
				break;
				
				default:
					$action = array_shift($aArgs);
					$response = call_user_func_array(array($this, $action), $aArgs);
					break;
			}
		} else {
			$response = 'forbidden access';
		}

		predie($response);
	}

	public function content($view){
		$this->tpl->content = $this->fetch($view);
	}

	/**
     * Trigger an event and call its observers
     */
    public function trigger($event, $data = FALSE)
    {
        if (isset($this->$event) && is_array($this->$event))
        {
            foreach ($this->$event as $method)
            {
                if (strpos($method, '('))
                {
                    preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);

                    $method = $matches[1];
                    $this->callback_parameters = explode(',', $matches[3]);
                }

                $data = call_user_func_array(array($this, $method), array($data));
            }
        }
        
        return $data;
    }
#R
    public function redirect($uri = '', $protocol = NULL, $index = TRUE){
    	return c_url::redirect($uri, $protocol, $index);
    }

	public function response( $mix ){
		$this->tpl->response = $array;
	}

    public function ts(){
        return self::getInstance();
    }
}
