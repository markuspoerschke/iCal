<?php

namespace Eluceo\iCal\Property\Event;

class GeoTest extends \PHPUnit_Framework_TestCase
{
    public function testGeoPropertyToLines()
    {
        $geo = new Geo(51.33, 7.05);
        $this->assertEquals(
            'GEO:51.330000;7.050000',
            $geo->toLine()
        );
    }
}
