<?php

namespace Eluceo\iCal\Property;

use Eluceo\iCal\Util\DateUtil;
use PHPUnit\Framework\TestCase;

class DateUtilTest extends TestCase
{
    public function testTimeConvertsToUTC()
    {
        $dateTime   = new \DateTime('2000-01-01T00:00:00+1000');
        $dateString = DateUtil::getDateString($dateTime, false, false, true);

        $this->assertEquals('19991231T140000Z', $dateString);
    }
    
    public function testTimeConvertsToUTCWithDateTimeImmutable()
    {
        $dateTime   = new \DateTimeImmutable('2000-01-01T00:00:00+1000');
        $dateString = DateUtil::getDateString($dateTime, false, false, true);

        $this->assertEquals('19991231T140000Z', $dateString);
    }

    public function testNoTimezoneConversionForDateOnly()
    {
        $dateTime   = new \DateTime('2000-01-01T00:00:00+1000');
        $dateString = DateUtil::getDateString($dateTime, true, false, true);

        $this->assertEquals('20000101', $dateString);
    }

    public function testNoTimezoneConversionWhenNotUsingUTC()
    {
        $dateTime   = new \DateTime('2000-01-01T00:00:00+1000');
        $dateString = DateUtil::getDateString($dateTime, false, false, false);

        $this->assertEquals('20000101T000000', $dateString);
    }

    public function testGetDefaultParamsOnNoTime()
    {
        $this->assertSame(['VALUE' => 'DATE'], DateUtil::getDefaultParams(null, true));
    }

    public function testGetDefaultParamsOnUseTimezone()
    {
        $this->assertSame(['TZID' => 'Asia/Taipei'], DateUtil::getDefaultParams(new \DateTime('now', new \DateTimeZone('Asia/Taipei')), false, true));
    }
}
