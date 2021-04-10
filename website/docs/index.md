---
title: Introduction
slug: /
---

The `eluceo/ical` package provides classes to generate `.ics` files.
The iCalendar specification is defined in [RFC 5545](https://tools.ietf.org/html/rfc5545) and allows sharing calendar information among different systems.

This package gives developers an abstraction, so that no deep knowledge of the iCalendar specification is needed.
The classes within the `Eluceo\iCal\Domain` namespace allow to store the information related to an event in simple PHP objects.
These domain objects can be transformed into a PHP representation of the iCalendar file format using the classes in the `Eluceo\iCal\Presentation` namespace.

The following code shows a minimal example how to render calendar with a single event:

```php
<?php

use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;

// 1. Create Event domain entity
$event = new Event();
$event
    ->setSummary('Christmas Eve')
    ->setOccurrence(
        new SingleDay(
            new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-24'))
        )
    );

// 2. Create Calendar domain entity
$calendar = new Calendar([$event]);

// 3. Transform domain entity into an iCalendar component
$componentFactory = new CalendarFactory();
$calendarComponent = $componentFactory->createCalendar($calendar);

// 4. Set HTTP headers
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');

// 5. Output
echo $calendarComponent;
```
