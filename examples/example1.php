<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Example;

use DateInterval;
use DateTimeImmutable;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Alarm;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\EmailAddress;
use Eluceo\iCal\Domain\ValueObject\GeographicPosition;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\Organizer;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\ValueObject\Uri;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Create Event domain entity.
$event = new Event();
$event
    ->setSummary('Christmas Eve')
    ->setDescription('Lorem Ipsum Dolor...')
    ->setOrganizer(new Organizer(
        new EmailAddress('john.doe@example.com'),
        'John Doe'
    ))
    ->setLocation(
        (new Location('Neuschwansteinstraße 20, 87645 Schwangau', 'Schloss Neuschwanstein'))
            ->withGeographicPosition(new GeographicPosition(47.557579, 10.749704))
    )
    ->setOccurrence(
        new TimeSpan(
            new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2030-12-24 13:30:00'), true),
            new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2030-12-24 14:30:00'), true)
        )
    )
    ->addAlarm(
        new Alarm(
            new Alarm\DisplayAction('Reminder: the meeting starts in 15 minutes!'),
            (new Alarm\RelativeTrigger(DateInterval::createFromDateString('-15 minutes')))->withRelationToEnd()
        )
    )
    ->addAttachment(
        new Attachment(
            new Uri('https://ical.poerschke.nrw/favicon.ico'),
            'image/x-icon'
        )
    )
;

// 2. Create Calendar domain entity.
$calendar = new Calendar([$event]);

// 3. Transform domain entity into an iCalendar component
$componentFactory = new CalendarFactory();
$calendarComponent = $componentFactory->createCalendar($calendar);

// 4. Set HTTP headers.
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');

// 5. Output.
echo $calendarComponent;
