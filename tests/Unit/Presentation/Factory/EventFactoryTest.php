<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Unit\Presentation\Factory;

use DateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Factory\EventFactory;
use PHPUnit\Framework\TestCase;

class CalendarFactoryTest extends TestCase
{
    public function testMinimalEvent()
    {
        $currentTime = Timestamp::fromDateTimeInterface(
            DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                '2019-11-10 11:22:33',
                new DateTimeZone('UTC')
            )
        );
        $event = Event::create(UniqueIdentifier::fromString('event1'))
            ->touch($currentTime)
            ->setSummary('Lorem Summary')
            ->setDescription('Lorem Description');

        $expected = implode(Component::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'UID:event1',
            'DTSTAMP:20191110T112233Z',
            'SUMMARY:Lorem Summary',
            'DESCRIPTION:Lorem Description',
            'END:VEVENT',
        ]);

        self::assertSame($expected, (string) (new EventFactory())->createComponent($event));
    }
}
