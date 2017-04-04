<?php

namespace Eluceo\iCal\Property;

use PHPUnit\Framework\TestCase;

class ArrayValueTest extends TestCase
{
    /**
     * @dataProvider arrayValuesProvider
     */
    public function testArrayValue($values, $expectedOutput)
    {
        $arrayValue = new ArrayValue($values);

        $this->assertEquals($expectedOutput, $arrayValue->getEscapedValue());
    }

    public function arrayValuesProvider()
    {
        return array(
            array(array(), ''),
            array(array('Lorem'), 'Lorem'),
            array(array('Lorem', 'Ipsum'), 'Lorem,Ipsum'),
            array(array('Lorem', '"doublequotes"'), 'Lorem,\"doublequotes\"'),
        );
    }
}
