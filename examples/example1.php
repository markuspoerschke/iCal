<?php

use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Create Event domain entity
$event = Event::create();
$event->withSummary('Christmas Eve');

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
