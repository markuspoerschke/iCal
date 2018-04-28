<?php

namespace Eluceo\iCal\Property;

use PHPUnit\Framework\TestCase;

class StringValueTest extends TestCase
{
    public function testNoEscapeNeeded()
    {
        $stringValue = new StringValue('LOREM');

        $this->assertEquals(
            'LOREM',
            $stringValue->getEscapedValue(),
            'No escaping necessary'
        );
    }

    public function testValueContainsBackslash()
    {
        $stringValue = new StringValue('text contains backslash: \\');

        $this->assertEquals(
            'text contains backslash: \\\\',
            $stringValue->getEscapedValue(),
            'Text contains backslash'
        );
    }

    public function testEscapingDoubleQuotes()
    {
        $stringValue = new StringValue('text with "doublequotes" will be escaped');

        $this->assertEquals(
            'text with \\"doublequotes\\" will be escaped',
            $stringValue->getEscapedValue(),
            'Escaping double quotes'
        );
    }

    public function testEscapingSemicolonAndComma()
    {
        $stringValue = new StringValue('text with , and ; will also be escaped');

        $this->assertEquals(
            'text with \\, and \\; will also be escaped',
            $stringValue->getEscapedValue(),
            'Escaping ; and ,'
        );
    }

    public function testNewLineEscaping()
    {
        $stringValue = new StringValue("Text with new\n line");

        $this->assertEquals(
            'Text with new\\n line',
            $stringValue->getEscapedValue(),
            'Escape new line to text'
        );
    }

    public function testSetValue()
    {
        $stringValue = new StringValue("Text with new\n line");
        $stringValue->setValue("Text with setting new value");

        $this->assertSame("Text with setting new value", $stringValue->getValue());
    }

    public function testGetValue()
    {
        $stringValue = new StringValue("Text with new\n line");

        $this->assertSame("Text with new\n line", $stringValue->getValue()); 
    }
}
