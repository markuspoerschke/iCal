# 📅 eluceo — iCal 2

[![Continuous Integration](https://github.com/markuspoerschke/iCal/actions/workflows/ci.yml/badge.svg)](https://github.com/markuspoerschke/iCal/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/markuspoerschke/iCal/branch/2.x/graph/badge.svg)](https://codecov.io/gh/markuspoerschke/iCal)
[![Psalm coverage](https://shepherd.dev/github/markuspoerschke/ical/coverage.svg?)](https://shepherd.dev/github/markuspoerschke/ical)
[![License](https://poser.pugx.org/eluceo/ical/license)](https://packagist.org/packages/eluceo/ical)
[![Latest Stable Version](https://poser.pugx.org/eluceo/ical/v/stable)](https://packagist.org/packages/eluceo/ical)
[![Monthly Downloads](https://poser.pugx.org/eluceo/ical/d/monthly)](https://packagist.org/packages/eluceo/ical)
[![Infection MSI](https://badge.stryker-mutator.io/github.com/markuspoerschke/iCal/2.x)](https://infection.github.io)

This package offers an abstraction layer for creating iCalendars files.
By using this PHP package, you can create `*.ics` files without the knowledge of the underling format.
The output itself will follow [RFC 5545](https://www.ietf.org/rfc/rfc5545.html) as good as possible.

## Navigate through the project

-   📖 [read the documentation](https://ical.poerschke.nrw)
-   🐛 [report a bug or suggest a feature](https://github.com/markuspoerschke/iCal/issues)
-   🙋 [raise a question](https://github.com/markuspoerschke/iCal/discussions/categories/q-a)
-   💬 [start a discussion](https://github.com/markuspoerschke/iCal/discussions)

## Installation

You can install this package by using [Composer](http://getcomposer.org), running the following command:

```sh
composer require eluceo/ical
```

## Version / Upgrade

The initial version was released back in 2012.
The version 2 of this package is a complete rewrite of the package and is not compatible to older version.
Please see the upgrade guide if you want to migrate from version `0.*` to `2.*`.
If you just start using this package, you should install version 2.

| Version | PHP Version |
| ------- | ----------- |
| 2.\*    | 7.4 - 8.2   |
| 0.16.\* | 7.0 - 8.2   |
| 0.11.\* | 5.3.0 - 7.4 |

## Documentation

Visit [ical.poerschke.nrw](https://ical.poerschke.nrw/) for complete documentation.

## Usage

The classes within this package are grouped into two namespaces:

-   The `Domain` contains the information about the events.
-   The `Presentation` contains the transformation from `Domain` into a `*.ics` file.

To create a calendar, the first step will be to create the corresponding domain objects.
Then these objects can be transformed into a iCalendar PHP representation, which can be cast to string.

### Empty event

In this very basic example, that renders an empty event.
You will learn how to create an event domain object, how to add it to a calendar and how to transform it to a iCalendar component.

#### 1. Create an event domain entity

```PHP
$event = new \Eluceo\iCal\Domain\Entity\Event();
```

#### 2. Create a calendar domain entity

```PHP
$calendar = new \Eluceo\iCal\Domain\Entity\Calendar([$event]);
```

#### 3. Transform calendar domain object into a presentation object

```PHP
$iCalendarComponent = (new \Eluceo\iCal\Presentation\Factory\CalendarFactory())->createCalendar($calendar);
```

#### 4. a) Save to file

```PHP
file_put_contents('calendar.ics', (string) $iCalendarComponent);
```

#### 4. b) Send via HTTP

```PHP
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');

echo $iCalendarComponent;
```

### Full example

The following example will create a single day event with a summary and a description.
More examples can be found in the [examples/](examples) folder.

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Create Event domain entity
$event = (new Eluceo\iCal\Domain\Entity\Event())
    ->setSummary('Christmas Eve')
    ->setDescription('Lorem Ipsum Dolor...')
    ->setOccurrence(
        new Eluceo\iCal\Domain\ValueObject\SingleDay(
            new Eluceo\iCal\Domain\ValueObject\Date(
                \DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-24')
            )
        )
    );

// 2. Create Calendar domain entity
$calendar = new Eluceo\iCal\Domain\Entity\Calendar([$event]);

// 3. Transform domain entity into an iCalendar component
$componentFactory = new Eluceo\iCal\Presentation\Factory\CalendarFactory();
$calendarComponent = $componentFactory->createCalendar($calendar);

// 4. Set headers
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');

// 5. Output
echo $calendarComponent;
```

## License

This package is released under the [**MIT license**](LICENSE).
