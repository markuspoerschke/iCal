<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\Entity;

use DateInterval;
use Eluceo\iCal\Domain\Entity\Calendar;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public function provideDateIntervalTestData(): array
    {
        return [
            [new DateInterval('P1W')],
            [null],
        ];
    }

    /**
     * @dataProvider provideDateIntervalTestData
     *
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::getPublishedTTL
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::setPublishedTTL
     *
     * @param ?DateInterval $ttl
     */
    public function testGetSetPublishedTTL($ttl): void
    {
        $calendar = new Calendar();
        $calendar->setPublishedTTL($ttl);
        self::assertSame($calendar->getPublishedTTL(), $ttl);
    }

    /**
     * @dataProvider provideDateIntervalTestData
     *
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::getRefreshInterval
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::setRefreshInterval
     *
     * @param ?DateInterval $ttl
     */
    public function testGetSetRefreshInterval($ttl): void
    {
        $calendar = new Calendar();
        $calendar->setRefreshInterval($ttl);
        self::assertSame($calendar->getRefreshInterval(), $ttl);
    }
}
