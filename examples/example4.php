<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Example;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\Entity\Attendee;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Todo;
use Eluceo\iCal\Domain\Enum\ParticipationStatus;
use Eluceo\iCal\Domain\Enum\RoleType;
use Eluceo\iCal\Domain\Enum\TodoStatus;
use Eluceo\iCal\Domain\ValueObject\Alarm;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\EmailAddress;
use Eluceo\iCal\Domain\ValueObject\Organizer;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\Uri;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Create a Todo domain entity.
$todo = new Todo();
$todo
    ->setSummary('Prepare v2.18.0 release')
    ->setDescription('Write changelog, update docs, create git tag and publish release notes.')
    ->setStatus(TodoStatus::IN_PROCESS())
    ->setPercentComplete(60)
    ->setStart(
        new Date(
            DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-20')
        )
    )
    ->setDue(
        new DateTime(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2030-12-24 18:00:00', new DateTimeZone('UTC')),
            false
        )
    )
    ->setCompletedAt(
        new Timestamp(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2030-12-24 17:45:00', new DateTimeZone('UTC'))
        )
    )
    ->setOrganizer(
        new Organizer(
            new EmailAddress('maintainer@example.com'),
            'Release Maintainer'
        )
    )
    ->addAttendee(
        (new Attendee(new EmailAddress('reviewer@example.com')))
            ->setRole(RoleType::REQ_PARTICIPANT())
            ->setParticipationStatus(ParticipationStatus::NEEDS_ACTION())
            ->setResponseNeededFromAttendee(true)
    )
    ->addAttachment(
        new Attachment(
            new Uri('https://example.com/releases/v2.18.0/checklist.pdf'),
            'application/pdf'
        )
    )
    ->addAlarm(
        new Alarm(
            new Alarm\DisplayAction('Reminder: release deadline is in 2 hours.'),
            (new Alarm\RelativeTrigger(DateInterval::createFromDateString('-2 hours')))->withRelationToEnd()
        )
    )
;

// 2. Create Calendar domain entity and add the todo.
$calendar = new Calendar();
$calendar->addTodo($todo);

// 3. Transform domain entity into an iCalendar component.
$componentFactory = new CalendarFactory();
$calendarComponent = $componentFactory->createCalendar($calendar);

// 4. Set HTTP headers.
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="todo.ics"');

// 5. Output.
echo $calendarComponent;
