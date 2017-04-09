<?php

namespace Eluceo\iCal;

use PHPUnit\Framework\TestCase;

class ParameterBagTest extends TestCase
{
    /**
     * @dataProvider escapedParamsDataProvider
     */
    public function testParamEscaping($value, $expected)
    {
        $propertyObject = new ParameterBag;
        $propertyObject->setParam('TEST', $value);

        $this->assertEquals(
            $expected,
            $propertyObject->toString()
        );
    }

    public function escapedParamsDataProvider()
    {
        return [
            'No escaping necessary' => ['test string', 'TEST=test string'],
            'Text contains double quotes' => ['Containing "double-quotes"', 'TEST="Containing \\"double-quotes\\""'],
            'Text with semicolon' => ['Containing forbidden chars like a ;', 'TEST="Containing forbidden chars like a ;"'],
            'Text with colon' => ['Containing forbidden chars like a :', 'TEST="Containing forbidden chars like a :"'],
        ];
    }
}
