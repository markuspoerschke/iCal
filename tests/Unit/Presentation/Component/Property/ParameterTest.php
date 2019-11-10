<?php

namespace Eluceo\iCal\Test\Unit\Presentation\Component\Property;

use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value\StringValue;
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testParameterToString()
    {
        $parameter = Parameter::create('TEST', StringValue::fromString('lorem ipsum'));
        self::assertSame('TEST=lorem ipsum', (string)$parameter);
    }
}
