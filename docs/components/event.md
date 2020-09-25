---
currentMenu: components/event
title: Event Component
---

# Event

The event domain object `\Eluceo\iCal\Domain\Entity\Event` represents a scheduled amount of time on a calendar.
For example, it can be an one-hour lunch meeting from 12:00 to 13:00 on 24th of december.

## Create new instance

When creating a new instance with the static method `Event::create`, the optional parameter `$uniqueIdentifier` can be set.
If it is not set, then a random, but unique identifier is created.

```php
use Eluceo\iCal\Domain\Entity\Event;

$event = new Event();
```

To set the properties, a fluent interface can be used:

```php
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\SingleDay;

$event = (new Event())
    ->setSummary('Lunch Meeting')
    ->setDescription('Lorem Ipsum...')
    ->setOccurrence(SingleDay::fromDate(Date::fromCurrentDay()));
```

## Properties

The following sections explain the properties of the domain object:

-   [Unique Identifier](#unique-identifier)
-   [Touched at](#touched-at)
-   [Summary](#summary)
-   [Description](#description)
-   [Occurrence](#occurrence)
-   [Location](#location)

### Unique Identifier

See [RFC 5545 section 3.8.4.7](https://tools.ietf.org/html/rfc5545#section-3.8.4.7).

A unique identifier must be a globally unique value.
When the value is generated, you must guarantee that it is unique.
Mostly this can be accomplished by adding the domain name to the identifier.

Given, the event id is stored in `$myEventUid`, than the event can be created using that id with the following code:

```php
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;

$myEventUid = 'example.com/event/1234';
$uniqueIdentifier = new UniqueIdentifier($myEventUid);
$event = new Event($uniqueIdentifier);
```

### Touched at

The `$touchedAt` property is a `Timestamp` that indicates when the event was changed.
If the event was just created, the value is equal to the creation time.
Therefore, the default value will be the current time.
The value can be changed using the `touch` method.

```php
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\Entity\Event;

$event = new Event();
$event->touch(Timestamp::fromCurrentTime());
```

A timestamp object can be also created from an object that implements `\DateTimeInterface` like this:

```php
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Timestamp;

$event = new Event();
$dateTime = DateTimeImmutable::createFromFormat('Y-m-d', '2019-12-24');
$timestamp = Timestamp::fromDateTimeInterface($dateTime);
$event->touch($timestamp);
```

### Summary

The summary of an event is a short, single line text, that describes the event.

```php
use Eluceo\iCal\Domain\Entity\Event;

$event = new Event();
$event->setSummary('Lunch Meeting');
```

### Description

In addition to the summary, the description gives more information about the event.

```php
use Eluceo\iCal\Domain\Entity\Event;

$event = new Event();
$event->setDescription('Lorem Ipsum Dolor...');
```

### Occurrence

The occurrence property of an event defines, when the event takes place.
There are currently three different types of occurrences possible:

-   [Single day](#single-day)
-   [Multi day](#multi-day)
-   [Timespan](#timespan)

#### Single day

The event will take place all day on the specified date.

The following example shows how to set the occurrence for an event that takes place on 24th of December 2019:

```php
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\Entity\Event;

$date = Date::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d', '2019-12-24'));
$occurrence = SingleDay::fromDate($date);

$event = new Event();
$event->setOccurrence($occurrence);
```

#### Multi day

A multi day event will take place on more than one consecutive day.
The multi day occurrence defines a span of days.

The named constructor `MultiDay::fromDates()` accepts two dates:

-   The `$firstDay` attribute defines the first inclusive day, the event will take place.
-   The `$lastDay` attribute defines the last inclusive day, the event will take place.

The given example

```php
use Eluceo\iCal\Domain\ValueObject\MultiDay;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\Entity\Event;

$firstDay = Date::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d', '2019-12-24'));
$lastDay = Date::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d', '2019-12-26'));
$occurrence = MultiDay::fromDates($firstDay, $lastDay);

$event = new Event();
$event->setOccurrence($occurrence);
```

will create an event that takes place on the 24th, 25th and 26th of december 2019.

#### Timespan

Unlike the previous types of occurrence, the timespan will consider the actual time, the event takes place.
A timespan defines the start and end time of an event.
These times define the span within the event will take place.

The following code example

```php
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\Entity\Event;

$start = DateTime::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-03 13:00:00'));
$end = DateTime::fromDateTimeInterface(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-03 14:00:00'));
$occurrence = TimeSpan::create($start, $end);

$event = new Event();
$event->setOccurrence($occurrence);
```

describes an event that takes place between 1pm and 2pm on 3rd of january 2020.

### Location

The location defines where an event takes place.
The value can be a generic name like the name of a meeting room or an address.
As an optional property, the exact [geographic position](https://en.wikipedia.org/wiki/Geographic_coordinate_system#Latitude_and_longitude) can be added.

```php
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\GeographicPosition;

$location = new Location('North Pole');

// optionally a location with a geographical position can be created
$location = $location->withGeographicPosition(GeographicPosition::fromLatitudeAndLongitude(64.751111,147.349444));

$event = new Event();
```
