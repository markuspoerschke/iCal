---
title: Event
---

The event domain object `\Eluceo\iCal\Domain\Entity\Event` represents a scheduled amount of time on a calendar.
For example, it can be an one-hour lunch meeting from 12:00 to 13:00 on 24th of december.

## Create new instance

When creating a new instance with the default construct method `new Event()`, the optional parameter `$uniqueIdentifier` can be set.
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
    ->setOccurrence(new SingleDay(new Date()));
```

## Properties

The following sections explain the properties of the domain object:

-   [Unique Identifier](#unique-identifier)
-   [Touched at](#touched-at)
-   [Summary](#summary)
-   [Description](#description)
-   [Occurrence](#occurrence)
-   [Location](#location)
-   [Organizer](#organizer)
-   [Attachments](#attachments)

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
$event->touch(new Timestamp());
```

A timestamp object can be also created from an object that implements `\DateTimeInterface` like this:

```php
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Timestamp;

$event = new Event();
$dateTime = DateTimeImmutable::createFromFormat('Y-m-d', '2019-12-24');
$timestamp = new Timestamp($dateTime);
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

### URL

The URL can be used to link to an arbitrary resource.

```php
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Uri;

$event = new Event();
$uri = new Uri("https://example.org/calendarevent");
$event->setUrl($uri);
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

$date = new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2019-12-24'));
$occurrence = new SingleDay($date);

$event = new Event();
$event->setOccurrence($occurrence);
```

#### Multi day

A multi day event will take place on more than one consecutive day.
The multi day occurrence defines a span of days.

The constructor `MultiDay($firstDay, $lastDay)` accepts two dates:

-   The `$firstDay` attribute defines the first inclusive day, the event will take place.
-   The `$lastDay` attribute defines the last inclusive day, the event will take place.

The given example

```php
use Eluceo\iCal\Domain\ValueObject\MultiDay;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\Entity\Event;

$firstDay = new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2019-12-24'));
$lastDay = new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2019-12-26'));
$occurrence = new MultiDay($firstDay, $lastDay);

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

$start = new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-03 13:00:00'), false);
$end = new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-03 14:00:00'), false);
$occurrence = new TimeSpan($start, $end);

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

$location = new Location('Neuschwansteinstraße 20, 87645 Schwangau');

// optionally you can create a location with a title for X-APPLE-STRUCTURED-LOCATION attribute
$location = new Location('Neuschwansteinstraße 20, 87645 Schwangau', 'Schloss Neuschwanstein');

// optionally a location with a geographical position can be created
$location = $location->withGeographicPosition(new GeographicPosition(47.557579, 10.749704));

$event = new Event();
$event->setLocation($location);
```

### Organizer

The Organizer defines the person who organises the event.
The property consists of at least an email address.
Optional a display name, or a directory entry (as used in LDAP for example) can be added.
In case the event was sent in behalf of another person, then the `sendBy` attribute will contain the email address.

```php
use Eluceo\iCal\Domain\ValueObject\Organizer;
use Eluceo\iCal\Domain\ValueObject\Uri;
use Eluceo\iCal\Domain\ValueObject\EmailAddress;
use Eluceo\iCal\Domain\Entity\Event;

$organizer = new Organizer(
    new EmailAddress('test@example.org'),
    'John Doe',
    new Uri('ldap://example.com:6666/o=ABC%20Industries,c=US???(cn=Jim%20Dolittle)'),
    new EmailAddress('sender@example.com')
);

$event = new Event();
$event->setOrganizer($organizer);
```

### Attachments

A document can be associated with an event.
It can be either be added as a URI or directly embedded as binary content.
It is strongly recommended to use the URI attachment, since binary content is not supported by all calendar applications.

```php
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use Eluceo\iCal\Domain\ValueObject\BinaryContent;
use Eluceo\iCal\Domain\ValueObject\Uri;

$urlAttachment = new Attachment(
    new Uri('https://example.com/test.txt'),
    'text/plain'
);

$binaryContentAttachment = new Attachment(
    new BinaryContent(file_get_contents('test.txt')),
    'text/plain'
);

$event = new Event();
$event->addAttachment($urlAttachment);
$event->addAttachment($binaryContentAttachment);
```
