<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danielsum
 * Date: 18/06/13
 * Time: 14:29
 * To change this template use File | Settings | File Templates.
 */

namespace Arx;

require_once ARX_CLASSES.DS.'html.php';

class cTest extends \PHPUnit_Framework_TestCase {

    public function testHTML()
    {
        die(c_html::attributes(array('class' => "test")));
    }
}
