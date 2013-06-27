<?php defined('SYSPATH') or die('No direct script access.');

require_once ARX_CLASSES . DS . 'kohana.php';
require_once ARX_CLASSES . DS . 'html.php';
require_once ARX_CLASSES . DS . 'kohana/form.php';

class form extends Kohana_Form {}

/**
     * Form Constructor extends forms
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @description :
     * @comments :
*/

class c_form extends Form
{
    private $_form, $_isClosed = false;

    public function __construct($action = NULL, $attributes = NULL)
    {
        return $this->_form = Form::open($action, $attributes);
    }

    public function __call($name, $args)
    {

        if($args[1] === true){
            $this->_form .= $this->label($args[0], $args[0]);
        }
        $this->_form .= call_user_func_array('Form::'.$name, $args);

        return $this;

    }

    public function __get($name)
    {

    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
        $this->_form = $value;

        return $this;

    }

    public function add($str){
        $this->_form .= $str;
        return $this;
    }

    public function br($br = '<br />'){
        return $this->add($br);
    }

    public static function open($action = null, $attributes = null)
    {
        return Form::open($action, $attributes);
    }

    public static function close()
    {
        if (isset($this)) {
            $this->_form .= Form::close();

            return $this->_form;
        } else {
            return Form::close();
        }
    }



    public function output($type = null)
    {

        $this->_form .= self::close();

        switch (true) {
            case ($type == 'html'):
                return nl2br(htmlspecialchars($this->_form));
            break;
            default:
                return $this->_form;
            break;
        }

    }

    public function outputHTML()
    {
        return self::output('html');
    }

}
