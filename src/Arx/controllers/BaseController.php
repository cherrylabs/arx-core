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
    public function assign($key, $value){
        $this->{$key} = $this->data[$key] = $value;
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
            'attributes' => array('class' => 'tpl-' . $layout)
        )));

        $data = $this->getCommonVars($data);

        return View::make($layout, $data);
    } // viewMake


    public function viewContent($layout, $data = array())
    {
        $data = array_merge($data, array('body' => array(
            'attributes' => array('class' => 'tpl-' . $layout)
        )));

        return $this->layout->content = View::make($layout, $this->getCommonVars($data));
    } // viewContent
}