<?php

namespace Eluceo\iCal\Test\Unit\Presentation\Component\Property\Value;

use Eluceo\iCal\Presentation\Component\Property\Value\StringValue;
use PHPUnit\Framework\TestCase;

class StringValueTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testStringValueEscaping(string $inputValue, string $expected)
    {
        self::assertSame($expected, (string)StringValue::fromString($inputValue));
    }

    public function provideTestData()
    {
        yield 'no escaping needed' => [
            'LOREM',
            'LOREM',
        ];
        yield 'backslashes are escaped' => [
            'text contains backslash: \\',
            'text contains backslash: \\\\',
        ];
        yield 'double quotes are escaped' => [
            'text with "doublequotes" will be escaped',
            'text with \\"doublequotes\\" will be escaped'
        ];
        yield 'semicolon and comma are escaped' => [
            'text with , and ; will also be escaped',
            'text with \\, and \\; will also be escaped',
        ];
        yield 'new lines are escaped' => [
            "Text with new\n line",
            'Text with new\\n line',
        ];
    }
}
