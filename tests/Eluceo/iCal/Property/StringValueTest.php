<?php

namespace Eluceo\iCal\Property;

use Eluceo\iCal\Property\StringValue;

class StringValueTest extends \PHPUnit_Framework_TestCase
{
    public function testNoEscapeNeeded()
    {
        $stringValue = new StringValue('LOREM');

        $this->assertEquals(
            'LOREM',
            $stringValue->getEscapedValue(),
            'No escaping nessesary'
        );
    }

    public function testValueContainsBackslash()
    {
        $stringValue = new StringValue('text contains backslash: \\');

        $this->assertEquals(
            'text contains backslash: \\\\',
            $stringValue->getEscapedValue(),
            'text contains backslash'
        );
    }

    public function testEscapingDoubleQuotes()
    {
        $stringValue = new StringValue('text with "doublequotes" will be escaped');

        $this->assertEquals(
            'text with \\"doublequotes\\" will be escaped',
            $stringValue->getEscapedValue(),
            'escaping double quotes'
        );
    }

    public function testEscapingSemicolonAndComma()
    {
        $stringValue = new StringValue('text with , and ; will also be escaped');

        $this->assertEquals(
            'text with \\, and \\; will also be escaped',
            $stringValue->getEscapedValue(),
            'escaping ; and ,'
        );
    }

    public function testNewLineEscaping()
    {
        $stringValue = new StringValue("Text with new\n line");

        $this->assertEquals(
            'Text with new\\n line',
            $stringValue->getEscapedValue(),
            'escape new line to text'
        );
    }
}
