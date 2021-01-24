<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Example;

use DateInterval;
use DateTimeImmutable;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Generator;

require_once __DIR__ . '/../vendor/autoload.php';

/*
 * In this example, the events are provided by a generator function.
 * This allows to stream the events through the ICS file generation process.
 */

// 1. Create event generator
$generator = function (): Generator {
    $day = new DateTimeImmutable();
    $dayInterval = new DateInterval('P1D');
    for ($i = 0; $i < 10; ++$i) {
        yield (new Event())
            ->setSummary('Event ' . $i)
            ->setOccurrence(new SingleDay(new Date($day)))
        ;
        $day = $day->add($dayInterval);
    }
};

// 2. Create Calendar domain entity.
$calendar = new Calendar($generator());

// 3. Transform domain entity into an iCalendar component
$componentFactory = new CalendarFactory();
$calendarComponent = $componentFactory->createCalendar($calendar);

// 4. Set HTTP headers.
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');

// 5. Output.
foreach ($calendarComponent as $line) {
    echo $line;
}
