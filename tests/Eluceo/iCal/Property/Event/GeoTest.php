<?php

namespace Eluceo\iCal\Property\Event;

use PHPUnit\Framework\TestCase;

class GeoTest extends TestCase
{
    public function testConstructor()
    {
        $geo = new Geo(25.632, 122.072);

        $this->assertInstanceOf(Geo::class, $geo);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The geographical latitude must be a value between -90 and 90 degrees. '-100' was given.
     */
    public function testConstructorOnInvalidLatitude()
    {
        new Geo(-100, 122.072);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The geographical longitude must be a value between -180 and 180 degrees. '-200' was given.
     */
    public function testConstructorOnInvalidLongitude()
    {
        new Geo(25.632, -200);
    }

    public function testFromString()
    {
        $geo = new Geo(25.632, 122.072);
        $newGeo = $geo->fromString('37.386013;-122.082932');

        $this->assertInstanceOf(Geo::class, $newGeo);
        $this->assertSame(37.386013, $newGeo->getLatitude());
        $this->assertSame(-122.082932, $newGeo->getLongitude());
    }

    public function testGetLatitude()
    {
        $geo = new Geo(25.632, 122.072);

        $this->assertSame(25.632, $geo->getLatitude());
    }

    public function testGetLongitude()
    {
        $geo = new Geo(25.632, 122.072);

        $this->assertSame(122.072, $geo->getLongitude());
    }
}
