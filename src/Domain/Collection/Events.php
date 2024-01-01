<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Collection;

use Eluceo\iCal\Domain\Entity\Event;
use Iterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<Event>
 */
abstract class Events implements IteratorAggregate
{
    /**
     * @return Iterator<Event>
     */
    abstract public function getIterator(): Iterator;

    abstract public function addEvent(Event $event): void;
}
