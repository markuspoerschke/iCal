<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Example;

use DateTimeImmutable;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\Entity\RecurrenceRule;
use Eluceo\iCal\Domain\Enum\RecurrenceFrequency;
use Eluceo\iCal\Domain\Enum\RecurrenceWeekDay;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\Day;
use Eluceo\iCal\Domain\ValueObject\Recurrence\By\SetPosition;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Count;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Exclusion;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Frequency;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Create the recurrence rule.
$rrule = new RecurrenceRule();
$rrule
    ->setFrequency(new Frequency(RecurrenceFrequency::monthly()))
    ->setCount(new Count(3))
    ->setBy(new By([
        new Day([
            RecurrenceWeekDay::tuesday(),
            RecurrenceWeekDay::wednesday(),
            RecurrenceWeekDay::thursday()
        ]),
        new SetPosition(3)
    ]))
    ->setExclusions(new Exclusion([
        new DateTime(new DateTimeImmutable('now'),false),
        new DateTime(new DateTimeImmutable('2023-10-23T10:00:00'),true),
    ]));

// 2. Create Event domain entity.
$event = new Event();
$event
    ->setSummary('Stand-up meeting')
    ->setOccurrence(
        new TimeSpan(
            new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-10-15 10:00:00'), true),
            new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-10-15 10:30:00'), true)
        )
    )
    ->setRecurrenceRule($rrule)
;

// 3. Create Calendar domain entity.
$calendar = new Calendar([$event]);

// 4. Transform domain entity into an iCalendar component
$componentFactory = new CalendarFactory();
$calendarComponent = $componentFactory->createCalendar($calendar);

// 5. Set HTTP headers.
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');

// 6. Output.
echo $calendarComponent;
