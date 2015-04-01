<?php namespace Arx;

use Arx\classes\Arr;
use Controller, View;

/**
 * Class BaseController
 *
 * Better BaseController inspired by CodeIgniter Data flow (merge data value)
 *
 * @package Arx
 */
class BaseController extends Controller {

    public static $tplPrefixClass = "tpl-";

    public $data = array();

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $data = array();

            // Enter here data that have to be accessible everywhere

            $this->layout = View::make($this->layout, $data);
        }
    } // setupLayout

    /**
     * Assign data to template and controller
     *
     * @param $key
     * @param $value
     */
    public function assign($key, $value = null){

        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;

            if(!isset($this->{$key})){
                $this->{$key} = $this->data[$key];
            }
        }
    }

    /**
     * @param array $otherDataToMerge
     * @param bool $addToCommon
     * @return mixed
     */
    public function getCommonVars($otherDataToMerge = array(), $addToCommon = false)
    {

        $data = Arr::merge($this->data, $otherDataToMerge);

        if ($addToCommon) {
            $this->data = $data;
        }

        # Put vars in javascript
        \Hook::put('__app', $this->data);

        return $data;
    } // getCommonVars

    /**
     * Same than View make but injects common vars
     *
     * @param $layout
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function viewMake($layout, $data = array())
    {
        $data = array_merge($data, array('body' => array(
            'attributes' => array('class' => static::$tplPrefixClass.str_replace(array('::', '.'), '-', $layout))
        )));

        $data = $this->getCommonVars($data);

        return View::make($layout, $data);
    } // viewMake

    /**
     * @param $layout
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function viewContent($layout, $data = array())
    {
        $data = array_merge($data, array('body' => array(
            'attributes' => array('class' => static::$tplPrefixClass.str_replace('::', '-', $layout))
        )));

        return $this->layout->content = View::make($layout, $this->getCommonVars($data));
    } // viewContent
}