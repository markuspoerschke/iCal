---
title: Custom Properties
---

The domain entities in these packages are equipped with the commonly needed properties.
In some cases these properties do not fully cover every use case.
In the following, a way how to add custom properties to the event entity and in result to the generated iCal file is described.

In this tutorial, we will add a custom property called `X-CUSTOM` to the iCal file, which can look like this:

```text
X-CUSTOM: foo bar baz!
```

## 1. Create a custom event domain entity

First we need to create a custom event entity to store the additional value.
This can be done by extending from `\Eluceo\iCal\Domain\Entity\Event`.
The following example shows a class with an added property named `$myCustomProperty`.
It is up to you, how to implement this class.
In this example, the property is read-only.

```php
namespace Documentation;

use Eluceo\iCal\Domain\Entity\Event;

class CustomEvent extends Event
{
    private string $myCustomProperty = 'foo bar baz!';

    public function getMyCustomProperty(): string
    {
        return $this->myCustomProperty;
    }
}
```

## 2. Create a custom event factory

The presentation components are created by factories.
It is possible to extend these factories to add custom properties to the iCal file.
In the following example, the factory reads the value `$myCustomProperty` and adds its value as property `X-CUSTOM`.

```php
namespace Documentation;

use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\Factory\EventFactory;

class CustomEventFactory extends EventFactory
{
    public function createComponent(Event $event): Component
    {
        $component = parent::createComponent($event);

        if ($event instanceof CustomEvent) {
            $component = $component->withProperty(
                new Property(
                    'X-CUSTOM',
                    new TextValue($event->getMyCustomProperty())
                )
            );
        }

        return $component;
    }
}
```

## 3. Let's plug it all together

A new custom event can now be created.

```php
$event = new CustomEvent();
$event->setSummary('This is a test event');
$calendar = new Calendar([$event]);
```

To see the new property, an instance of class `CustomEventFactory` must be passed to the standard calendar factory:

```php
$calendarComponentFactory = new CalendarFactory(new CustomEventFactory());
$calendarComponent = $calendarComponentFactory->createCalendar($calendar);
```

After that, the iCal file can be rendered like normal.

```php
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');
echo $calendarComponent;
```

For a full sample, please have a look at [`example2.php`](https://github.com/markuspoerschke/iCal/blob/master/examples/example2.php).
