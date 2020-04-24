---
currentMenu: components/calendar
title: Calendar Component
---

# Calendar

The calendar is basically a collection of events.
A calendar can be represented as a `.ical` file.

## Adding events to the calendar

Events can be either added via the named constructor:

```php
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;

$events = [
    Event::create(),
    Event::create(),
];

$calendar = Calendar::create($events);
```

or calling the `addEvent` method:

```php
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;

$calendar = Calendar::create();
$calendar
    ->addEvent(Event::create())
    ->addEvent(Event::create());
```

or providing a generator, that creates events:

```php
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;

$eventGenerator = function(): Generator {
    yield Event::create();
    yield Event::create();
};

$calendar = Calendar::create($eventGenerator());
```
