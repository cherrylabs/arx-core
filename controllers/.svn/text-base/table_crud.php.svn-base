<?php
/**
    * Control Crud class
    * @file
    *
    * @package
    * @author Daniel Sum
    * @link 	@endlink
    * @see
    * @description
    *
    * @code

          $controller = new ctrl_table_crud('Your_Table');

          $controller->display();

      @endcode
    * @comments
    * @todo
*/

global $cfg;

arx::uses( $cfg['system']['orm'] );

class ctrl_table_crud extends c_controller
{

    public $_a, $_table;

    public function __construct($table)
    {
        $this->_a = new arx();

        $this->_table = a_db::findAll($table);

        switch (true) {
            case ($_POST['action'] == 'create'):

            break;
            case ($_POST['action'] == 'read'):

            break;

            case ($_POST['action'] == 'update'):

            break;

            case ($_POST['action'] == 'delete'):

            break;

            default:

            break;
        }

        return $this;

    }

    public function render($type = 'html5')
    {
        return 'okiiiiii';
    }

    public function display($type = 'html5')
    {
        $a = $this->_a;
        //@TODO : query

        c_hook::css(array(ARX_CSS.DS.'bootstrap.css', ARX_CSS.DS.'arx.css'));

        c_hook::js(array(ARX_JS.DS.'jquery.js',ARX_JS.DS.'jquery.datatable.js', ARX_JS.DS.'arx.js', ));

        predie($GLOBALS['hooked_css']);

        $a->_body = $a->fetch(ARX_HELPERS.DS.'table_crud.tpl', array('data'=>$this->_table));

        switch (true) {
            case ($type == 'html5'):
                $a->display(ARX_VIEWS.DS.'html5.tpl');
            break;
        }

    }
}
