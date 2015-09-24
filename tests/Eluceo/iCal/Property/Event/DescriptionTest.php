<?php

namespace Eluceo\iCal\Property\Event;

class DescriptionTest extends \PHPUnit_Framework_TestCase
{
    public function testAllowsNewLines()
    {
        $testString = "New String \n New Line";
        $description = new Description($testString);

        $this->assertEquals(
            $testString,
            $description->getEscapedValue()
        );
    }
}
