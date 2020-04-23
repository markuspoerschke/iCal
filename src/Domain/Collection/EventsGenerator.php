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

use BadMethodCallException;
use Eluceo\iCal\Domain\Entity\Event;
use Iterator;

final class EventsGenerator extends Events
{
    /**
     * @var Iterator<Event>
     */
    private Iterator $generator;

    /**
     * @param Iterator<Event> $generator
     */
    private function __construct(Iterator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param Iterator<Event> $generator
     */
    public static function fromGenerator(Iterator $generator): self
    {
        return new static($generator);
    }

    public function getIterator()
    {
        return $this->generator;
    }

    public function addEvent(Event $event): void
    {
        throw new BadMethodCallException('Events cannot be added to an EventsGenerator.');
    }
}
