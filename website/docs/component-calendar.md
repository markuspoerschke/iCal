---
title: Calendar
---

The calendar is basically a collection of events.
A calendar can be represented as a `.ical` file.

## Adding events

Events can be either added via the named constructor:

```php
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;

$events = [
    new Event(),
    new Event(),
];

$calendar = new Calendar($events);
```

or calling the `addEvent` method:

```php
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;

$calendar = new Calendar();
$calendar
    ->addEvent(new Event())
    ->addEvent(new Event());
```

or providing a generator, that creates events:

```php
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;

$eventGenerator = function(): Generator {
    yield new Event();
    yield new Event();
};

$calendar = new Calendar($eventGenerator());
```

## Adding time zones

When working with local times, time zone definitions should be added:

```php
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\TimeZone;
use DateTimeZone as PhpDateTimeZone;

$calendar = new Calendar();
$calendar
    ->addTimeZone(TimeZone::createFromPhpDateTimeZone(new PhpDateTimeZone('Europe/Berlin')))
    ->addTimeZone(TimeZone::createFromPhpDateTimeZone(new PhpDateTimeZone('Europe/London')))
;
```
