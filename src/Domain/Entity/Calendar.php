<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Entity;

use Eluceo\iCal\Domain\Collection\Events;
use Eluceo\iCal\Domain\Collection\EventsArray;
use Iterator;

class Calendar
{
    private string $productIdentifier = '-//eluceo/ical//2.0/EN';

    private Events $events;

    private function __construct(Events $events)
    {
        $this->events = $events;
    }

    /**
     * @param array<Event>|Iterator<Event>|Events $events
     */
    public static function create($events = []): self
    {
        if (is_array($events)) {
            $events = EventsArray::fromArray($events);
        } elseif (is_object($events) && $events instanceof Iterator) {
            $events = Events::fromGenerator($events);
        }

        if (!is_object($events) || !$events instanceof Events) {
            throw new \InvalidArgumentException('$events must be an array, an object implementing Iterator or an instance of Events.');
        }

        return new static($events);
    }

    public function getProductIdentifier(): string
    {
        return $this->productIdentifier;
    }

    public function setProductIdentifier(string $productIdentifier): self
    {
        $this->productIdentifier = $productIdentifier;

        return $this;
    }

    public function getEvents(): Events
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        $this->events->addEvent($event);

        return $this;
    }
}
