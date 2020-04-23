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

use Eluceo\iCal\Domain\Entity\Event;
use Iterator;
use IteratorAggregate;

abstract class Events implements IteratorAggregate
{
    /**
     * @return Iterator<Event>
     */
    abstract public function getIterator();

    abstract public function addEvent(Event $event): void;

    /**
     * @param Event[] $events
     */
    public static function fromArray(array $events): self
    {
        return EventsArray::fromArray($events);
    }

    /**
     * @param Iterator<Event> $generator
     */
    public static function fromGenerator(Iterator $generator): self
    {
        return EventsGenerator::fromGenerator($generator);
    }
}
