<?php

namespace Eluceo\iCal\Test\Unit\Presentation\Component\Property\Value;

use Eluceo\iCal\Presentation\Component\Property\Value\ListValue;
use Eluceo\iCal\Presentation\Component\Property\Value\StringValue;
use PHPUnit\Framework\TestCase;

class ListValueTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testStringValueEscaping(array $values, string $expected)
    {
        self::assertSame($expected, (string)ListValue::fromStringValues($values));
    }

    public function provideTestData()
    {
        yield 'empty list value' => [
            [],
            '',
        ];
        yield 'single value' => [
            [StringValue::fromString('Lorem')],
            'Lorem'
        ];
        yield 'multiple values without escaping' => [
            [
                StringValue::fromString('Lorem'),
                StringValue::fromString('Ipsum'),
                StringValue::fromString('Dolor')
            ],
            'Lorem,Ipsum,Dolor'
        ];
        yield 'multiple values with escaping' => [
            [
                StringValue::fromString('Lorem'),
                StringValue::fromString('Ips,um'),
                StringValue::fromString('"doublequotes"')
            ],
            'Lorem,Ips\,um,\"doublequotes\"'
        ];
    }
}
