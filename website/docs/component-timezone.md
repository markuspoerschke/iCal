---
title: Time Zone
---

The time zone event domain object `\Eluceo\iCal\Domain\Entity\TimeZone` represents a definition of a time zone.
It contains the transitions of standard and daylight saving time and defines offsets to the UTC time.

When using local time, the time zone should be defined to ensure correct local time.

## Fixed transitions

The easiest way to define a time zone is the automatic conversion of PHP date time zones (`\DateTimeZone`) into the domain object:

```php
use Eluceo\iCal\Domain\Entity\TimeZone;
use DateTimeZone as PhpDateTimeZone;

$timeZone = TimeZone::createFromPhpDateTimeZone(new PhpDateTimeZone('Europe/Berlin'));
```

To avoid too much output in the generated iCal file, the lowest and the highest date can be passed:

```php
use Eluceo\iCal\Domain\Entity\TimeZone;
use DateTimeZone as PhpDateTimeZone;

$phpDateTimeZone = new PhpDateTimeZone('Europe/Berlin');
$timeZone = TimeZone::createFromPhpDateTimeZone(
    $phpDateTimeZone,
    new DateTimeImmutable('2019-05-01 15:00:00', $phpDateTimeZone),
    new DateTimeImmutable('2020-12-24 18:00:00', $phpDateTimeZone),
);
```

Timespan events in calendars with time zones should set the `DateTime` `$applyTimeZone` argument to `true` to include time zones with the resulting timestamps.

```php
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\ValueObject\DateTime;

new TimeSpan(new DateTime($starTime, true), new DateTime($endTime, true));
```

## Recurrence rules

Not implemented yet.
