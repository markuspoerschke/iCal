<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Example;

use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Eluceo\iCal\Presentation\Factory\EventFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Define a custom event domain entity.
class CustomEvent extends Event
{
    private string $myCustomProperty = 'foo bar baz!';

    public function getMyCustomProperty(): string
    {
        return $this->myCustomProperty;
    }
}

// 2. Create a custom event factory,
//    that can add the additional property to the presentation component.
class CustomEventFactory extends EventFactory
{
    public function createComponent(Event $event): Component
    {
        $component = parent::createComponent($event);

        if ($event instanceof CustomEvent) {
            $component = $component->withProperty(
                Property::create(
                    'X-CUSTOM',
                    TextValue::fromString($event->getMyCustomProperty())
                )
            );
        }

        return $component;
    }
}

// 3. Create events and calendar objects as normal.
$event = CustomEvent::create();
$event->setSummary('This is a test event');
$calendar = Calendar::create([$event]);

// 4. Pass your custom event factory to the calendar factory via the constructor call.
$calendarComponentFactory = new CalendarFactory(new CustomEventFactory());
$calendarComponent = $calendarComponentFactory->createCalendar($calendar);

// 5. The output can happen as usual.
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');
echo $calendarComponent;
