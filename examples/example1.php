<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Create Event domain entity
$event = Event::create()
    ->withSummary('Christmas Eve')
    ->withDescription('Lorem Ipsum Dolor...')
    ->withOccurrence(
        \Eluceo\iCal\Domain\ValueObject\TimeSpan::create(
            DateTime::fromDateTimeInterface(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2030-12-24 13:30:00')
            ),
            DateTime::fromDateTimeInterface(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2030-12-24 14:30:00')
            )
        )
    );

// 2. Create Calendar domain entity
$calendar = Calendar::create([$event]);

// 3. Transform domain entity into an iCalendar component
$componentFactory = new CalendarFactory();
$calendarComponent = $componentFactory->createCalendar($calendar);

// 4. Set headers
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');

// 5. Output
echo $calendarComponent;
