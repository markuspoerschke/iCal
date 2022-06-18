<?php

namespace Eluceo\iCal\Component;

use Eluceo\iCal\Property\Event\Geo;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testSetDtEnd()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setDtEnd('19960401T235959Z');

        $this->assertSame('19960401T235959Z', $event->getDtEnd());
    }

    public function testGetDtEnd()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');

        $this->assertNull($event->getDtEnd());
    }

    public function testSetDtStart()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setDtStart('19980118T073000Z');

        $this->assertSame('19980118T073000Z', $event->getDtStart());
    }

    public function testGetDtStart()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');

        $this->assertNull($event->getDtStart());
    }

    public function testSetDtStamp()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setDtStamp(new \DateTime('2000-01-01T00:00:00+1000'));
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('UID:19960401T080045Z-4000F192713-0052@host1.com', $result['UID']->toLine());
        $this->assertSame('DTSTAMP:19991231T140000Z', $result['DTSTAMP']->toLine());
    }

    public function testSetDuration()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setDuration(new \DateInterval('PT15M'));
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('DURATION:P0DT0H15M0S', $result['DURATION']->toLine());
    }

    public function testSetLocation()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setLocation('Conference Room - F123, Bldg. 002');
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('LOCATION:Conference Room - F123\, Bldg. 002', $result['LOCATION']->toLine());
    }

    public function testSetLocationOnInvalidGeo()
    {
        $this->expectExceptionMessage("The parameter 'geo' must be a string or an instance of Eluceo\iCal\Property\Event\Geo but an instance of ArrayObject was given.");
        $this->expectException(\InvalidArgumentException::class);

        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setLocation('Conference Room - F123, Bldg. 002', '', new \ArrayObject([25.632, 122.072]));
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('LOCATION:Conference Room - F123\, Bldg. 002', $result['LOCATION']->toLine());
    }

    public function testSetLocationOnGeoString()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setLocation('Conference Room - F123, Bldg. 002', '', '25.632, 122.072');
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('LOCATION:Conference Room - F123\, Bldg. 002', $result['LOCATION']->toLine());
    }

    public function testSetGeoLocation()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setGeoLocation(new Geo(25.632, 122.072));
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('GEO:25.632000;122.072000', $result['GEO']->toLine());
    }

    public function testSetNoTime()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setNoTime(true);
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertArrayHasKey('DTSTAMP', $result);
    }

    public function testSetMsBusyTime()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setMsBusyStatus("FREE");
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('X-MICROSOFT-CDO-BUSYSTATUS:FREE', $result['X-MICROSOFT-CDO-BUSYSTATUS']->toLine());
    }

    public function testGetMsBusyTime()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setMsBusyStatus("FREE");

        $this->assertSame("FREE", $event->getMsBusyStatus());
    }

    public function testSetSequence()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setSequence(1);
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('SEQUENCE:1', $result['SEQUENCE']->toLine());
    }

    public function testGetSequence()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setSequence(1);

        $this->assertSame(1, $event->getSequence());
    }

    public function testSetSummary()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setSummary('Department Party');
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('SUMMARY:Department Party', $result['SUMMARY']->toLine());
    }

    public function testSetUniqueId()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setUniqueId('19960401T080045Z-4000F192713-0052@host2.com');

        $this->assertSame('19960401T080045Z-4000F192713-0052@host2.com', $event->getUniqueId());
    }

    public function testGetUniqueId()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');

        $this->assertSame('19960401T080045Z-4000F192713-0052@host1.com', $event->getUniqueId());
    }

    public function testSetUrl()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setUrl('https://google.com.tw');
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertSame('URL:https://google.com.tw', $result['URL']->toLine());
    }

    public function testSetTimezoneString()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setTimezoneString('Asia/Taipei');
        $result = $event->buildPropertyBag()->getIterator()->getArrayCopy();

        $this->assertArrayHasKey('DTSTART', $result);
    }

    public function testGetTimezoneString()
    {
        $event = new Event('19960401T080045Z-4000F192713-0052@host1.com');
        $event->setTimezoneString('Asia/Taipei');

        $this->assertSame('Asia/Taipei', $event->getTimezoneString());
    }
}
