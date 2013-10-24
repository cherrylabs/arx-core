<?php
/**
 * Test.php.
 * @project : arx
 * @author  : danielsum
 */

use Arx\classes\Bag;

class BagTest extends PHPUnit_Framework_TestCase
{

    public function testBag()
    {

        $data = array(
            'string' => 'string',
            'array' => array('title' => 'title'),
            'object' => json_decode(json_encode(array('title' => 'title')))
        );

        $container = new Bag($data);

        foreach ($container['array'] as $key => $value) {
            $boucle = $value;
        }

        $this->assertSame('string', (string) $container['string'], 'Not the same');

        $this->assertEquals('title', $boucle, 'Not passing in the boucle');

        $this->assertSame('title', (string) $container['array']['title'], 'should be the same');

        $this->assertSame('title', (string) $container['object']->title, 'should be the same');

        $this->assertFalse($container->fake, 'Should be false');
        $this->assertFalse($container['fake'], 'Should be false');
        $this->assertFalse($container['array']['fake'], 'should be false');
        $this->assertFalse($container['object']->fake, 'should be false');
    }
}