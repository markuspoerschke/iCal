<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Collection;

use ArrayIterator;
use Eluceo\iCal\Domain\Entity\Event;

final class EventsArray extends Events
{
    /**
     * @var Event[]
     */
    private array $events = [];

    private function __construct(array $events)
    {
        array_walk($events, [$this, 'addEvent']);
    }

    public static function fromArray(array $events): self
    {
        return new static($events);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->events);
    }

    public function addEvent(Event $event): void
    {
        $this->events[] = $event;
    }
}
