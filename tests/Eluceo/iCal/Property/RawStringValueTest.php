<?php

namespace Eluceo\iCal\Property;

use PHPUnit\Framework\TestCase;

class RawStringValuetTest extends TestCase
{
    public function testGetEscapedValue()
    {
        $rawStringValue = new RawStringValue('string_value');
        $this->assertSame('string_value', $rawStringValue->getEscapedValue());
    }
}
