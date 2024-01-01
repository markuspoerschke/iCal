<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Presentation\Factory;

use DateTimeImmutable;
use Eluceo\iCal\Domain\Entity\TimeZone;
use Eluceo\iCal\Domain\Enum\TimeZoneTransitionType;
use Eluceo\iCal\Domain\ValueObject\TimeZoneTransition;
use Eluceo\iCal\Presentation\ContentLine;
use Eluceo\iCal\Presentation\Factory\TimeZoneFactory;
use PHPUnit\Framework\TestCase;

class TimeZoneFactoryTest extends TestCase
{
    public function testCreateComponents(): void
    {
        $timeZone = new TimeZone('Europe/Test');
        $timeZone->setTransitions([
            new TimeZoneTransition(
                TimeZoneTransitionType::STANDARD(),
                new DateTimeImmutable('2021-01-01 00:00:00'),
                7200,
                3600,
                'TimeZone1'
            ),
            new TimeZoneTransition(
                TimeZoneTransitionType::DAYLIGHT(),
                new DateTimeImmutable('2021-03-01 00:00:00'),
                3600,
                7200,
                'TimeZone2'
            ),
        ]);

        self::assertTimeZonesRendersCorrect([$timeZone], [
            'BEGIN:VTIMEZONE',
            'TZID:Europe/Test',
            'BEGIN:STANDARD',
            'DTSTART:20210101T000000',
            'TZNAME:TimeZone1',
            'TZOFFSETTO:+0100',
            'TZOFFSETFROM:+0200',
            'END:STANDARD',
            'BEGIN:DAYLIGHT',
            'DTSTART:20210301T000000',
            'TZNAME:TimeZone2',
            'TZOFFSETTO:+0200',
            'TZOFFSETFROM:+0100',
            'END:DAYLIGHT',
            'END:VTIMEZONE',
        ]);
    }

    private static function assertTimeZonesRendersCorrect(iterable $timeZones, array $expected)
    {
        $components = iterator_to_array((new TimeZoneFactory())->createComponents($timeZones));
        $componentsAsString = array_map('strval', $components);
        $resultAsString = implode(ContentLine::LINE_SEPARATOR, $componentsAsString);

        self::assertSame(
            implode(ContentLine::LINE_SEPARATOR, $expected),
            trim($resultAsString)
        );
    }
}
