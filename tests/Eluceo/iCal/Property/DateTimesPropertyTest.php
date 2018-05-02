<?php

namespace Eluceo\iCal\Property;

use PHPUnit\Framework\TestCase;

class DateTimesPropertyTest extends TestCase
{
    public function testConstructor()
    {
        $this->assertInstanceOf(DateTimesProperty::class, new DateTimesProperty('propertyName'));
    }

    public function testConstructorOnDateTimes()
    {
        $this->assertInstanceOf(DateTimesProperty::class, new DateTimesProperty('propertyName', [new \DateTime('2000-01-01T00:00:00+1000')]));
    }
}