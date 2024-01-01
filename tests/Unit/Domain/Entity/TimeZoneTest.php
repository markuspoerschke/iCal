<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Domain\Entity;

use DateTimeImmutable;
use DateTimeZone as PhpDateTimeZone;
use Eluceo\iCal\Domain\Entity\TimeZone;
use Eluceo\iCal\Domain\Enum\TimeZoneTransitionType;
use Eluceo\iCal\Domain\ValueObject\TimeZoneTransition;
use PHPUnit\Framework\TestCase;

class TimeZoneTest extends TestCase
{
    public function testCreateFromPhpDateTimeZone(): void
    {
        $phpDateTimeZone = new PhpDateTimeZone('Europe/Berlin');
        $actual = TimeZone::createFromPhpDateTimeZone(
            $phpDateTimeZone,
            new DateTimeImmutable('2020-01-01 00:00:00', $phpDateTimeZone),
            new DateTimeImmutable('2021-01-01 00:00:00', $phpDateTimeZone)
        );

        $expected = new TimeZone('Europe/Berlin');
        $expected
            ->addTransition(
                new TimeZoneTransition(
                    TimeZoneTransitionType::STANDARD(),
                    new DateTimeImmutable('2020-01-01 00:00:00', $phpDateTimeZone),
                    3600,
                    3600,
                    'CET'
                )
            )
            ->addTransition(
                new TimeZoneTransition(
                    TimeZoneTransitionType::DAYLIGHT(),
                    new DateTimeImmutable('2020-03-29 02:00:00', $phpDateTimeZone),
                    3600,
                    7200,
                    'CEST'
                )
            )
            ->addTransition(
                new TimeZoneTransition(
                    TimeZoneTransitionType::STANDARD(),
                    new DateTimeImmutable('2020-10-25 02:00:00', $phpDateTimeZone),
                    7200,
                    3600,
                    'CET'
                )
            )
        ;

        self::assertEquals($expected, $actual);
    }
}
