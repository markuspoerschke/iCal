<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation\Component\Property\Value;

use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use PHPUnit\Framework\TestCase;

class TextValueTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testStringValueEscaping(string $inputValue, string $expected)
    {
        self::assertSame($expected, (string) (new TextValue($inputValue)));
    }

    public function provideTestData()
    {
        yield 'example from RFC 5545' => [
            "Project XYZ Final Review\nConference Room - 3B\nCome Prepared.",
            'Project XYZ Final Review\\nConference Room - 3B\\nCome Prepared.',
        ];
        yield 'no escaping needed' => [
            'LOREM',
            'LOREM',
        ];
        yield 'backslashes are escaped' => [
            'text contains backslash: \\',
            'text contains backslash: \\\\',
        ];
        yield 'do not escape double quotes' => [
            'This is a "test".',
            'This is a "test".',
        ];
        yield 'semicolon and comma are escaped' => [
            'text with , and ; will also be escaped',
            'text with \\, and \\; will also be escaped',
        ];
        yield 'new lines are escaped' => [
            "Text with new\n line",
            'Text with new\\n line',
        ];
        yield 'do not escape colon' => [
            'Text containing: colon are not escaped',
            'Text containing: colon are not escaped',
        ];
        yield 'test control characters are removed' => [
            "All the controls \x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19\x1a\x1b\x1c\x1d\x1e\x1f\x7f are escaped",
            'All the controls \\n are escaped',
        ];
    }
}
