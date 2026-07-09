---
title: Non-standard Properties
---

## X-PUBLISHED-TTL

The [`X-PUBLISHED-TTL`](<http://msdn.microsoft.com/en-us/library/ee178699(v=exchg.80).aspx>) property specifies a suggested iCalendar file download frequency for clients and servers with sync capabilities.

Use the `setPublishedTTL()` method with a [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601#Durations)-formatted string to set this duration.

```php
use Eluceo\iCal\Domain\Entity\Calendar;

$calendar = new Calendar();
// set the duration to 2 hours
$calendar->setPublishedTTL(new DateInterval('PT2H'))
```

## X-WR-CALNAME

The [`X-WR-CALNAME`](https://learn.microsoft.com/en-us/openspecs/exchange_server_protocols/ms-oxcical/1da58449-b97e-46bd-b018-a1ce576f3e6d) property specifies the display name of a calendar.

This property is not part of the iCalendar RFC, but it is used by some calendar clients.

Use the `setCalName()` method to set this value.

```php
use Eluceo\iCal\Domain\Entity\Calendar;

$calendar = new Calendar();
$calendar->setCalName('Team Calendar');
```
