<?php defined('SYSPATH') or die('No direct script access.');

class c_controller extends Arx
{
	

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
}
