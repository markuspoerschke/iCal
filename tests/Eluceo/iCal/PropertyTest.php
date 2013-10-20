<?php

namespace Eluceo\iCal;

class PropertyTest extends \PHPUnit_Framework_TestCase
{
    public function testEscapeParamValue()
    {
        $propertyObject = new Property('', '');

        $this->assertEquals(
            'test string',
            $propertyObject->escapeParamValue('test string'),
            'No escaping nessesary'
        );

        $this->assertEquals(
            '"Containing \\"double-quotes\\""',
            $propertyObject->escapeParamValue('Containing "double-quotes"'),
            'Text contins double quotes'
        );

        $this->assertEquals(
            '"Containing forbidden chars like a ;"',
            $propertyObject->escapeParamValue('Containing forbidden chars like a ;'),
            'Text with semicolon'
        );
    }

    public function testEscapeValue()
    {
        $propertyObject = new Property('', '');

        $this->assertEquals(
            'LOREM',
            $propertyObject->escapeValue('LOREM'),
            'No escaping nessesary'
        );

        $this->assertEquals(
            'text contains backslash: \\\\',
            $propertyObject->escapeValue('text contains backslash: \\'),
            'text contains backslash'
        );

        $this->assertEquals(
            'text with \\"doublequotes\\" will be escaped',
            $propertyObject->escapeValue('text with "doublequotes" will be escaped'),
            'escaping double quotes'
        );

        $this->assertEquals(
            'text with \\, and \\; will also be escaped',
            $propertyObject->escapeValue('text with , and ; will also be escaped'),
            'escaping ; and ,'
        );

        $this->assertEquals(
            'Text with new\\n line',
            $propertyObject->escapeValue("Text with new\n line"),
            'escape new line to text'
        );
    }

    public function testPropertyWithSingleValue()
    {
        $property = new Property('DTSTAMP', '20131020T153112');
        $this->assertEquals(
            'DTSTAMP:20131020T153112',
            $property->toLine()
        );
    }

    public function testPropertyWithValueAndParams()
    {
        $property =new Property('DTSTAMP', '20131020T153112', array('TZID' => 'Europe/Berlin'));
        $this->assertEquals(
            'DTSTAMP;TZID=Europe/Berlin:20131020T153112',
            $property->toLine()
        );
    }

    public function testPropertyWithEscapedSingleValue()
    {
        $property = new Property('SOMEPROP', 'Escape me!"');
        $this->assertEquals(
            'SOMEPROP:Escape me!\\"',
            $property->toLine()
        );
    }

    public function testPropertyWithEscapedValues()
    {
        $property = new Property('SOMEPROP', 'Escape me!"', array('TEST' => 'Lorem "test" ipsum'));
        $this->assertEquals(
            'SOMEPROP;TEST="Lorem \\"test\\" ipsum":Escape me!\\"',
            $property->toLine()
        );
    }
}
