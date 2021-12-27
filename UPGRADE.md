# Upgrade from `0.16.*` to `2.0`

The fundamental change in version 2 two is the separation between presentation and domain layers.

This library was created with the goal that the user should know as little as possible about the iCal standard and
still be able to create usable iCal files.

## Example Upgrade

Given you have the following Code from version `0.16.*`:

```php
$vEvent = new \Eluceo\iCal\Component\Event();

$vEvent
    ->setDtStart(new \DateTime('2012-12-24'))
    ->setDtEnd(new \DateTime('2012-12-24'))
    ->setNoTime(true)
    ->setSummary('Christmas')
;

$vCalendar = new \Eluceo\iCal\Component\Calendar('www.example.com');
$vCalendar->addComponent($vEvent);

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');

echo $vCalendar->render();
```

The code will be structured very similar. In version `0.16.*`, the event could be sent to output directly.
In contrast, in version 2, the domain object must first be passed to a factory that creates the iCal presentation.

The above code will look like the following after upgrading to version 2.

```php
// 1. Create Event domain entity
$event = (new Eluceo\iCal\Domain\Entity\Event())
    ->setSummary('Christmas Eve')
    ->setDescription('Lorem Ipsum Dolor...')
    ->setOccurrence(
        new Eluceo\iCal\Domain\ValueObject\SingleDay(
            new Eluceo\iCal\Domain\ValueObject\Date(
                \DateTimeImmutable::createFromFormat('Y-m-d', '2012-12-24')
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

## Documentation

In version 0.16.x the documentation consisted mainly of example files.
For version 2, a completely new documentation was created, which deals with all properties of the domain objects.
The documentation can be found here: https://ical.poerschke.nrw
