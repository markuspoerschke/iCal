<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Collection;

use Eluceo\iCal\Domain\Entity\Event;
use Iterator;
use IteratorAggregate;
use ReturnTypeWillChange;

/**
 * @implements IteratorAggregate<Event>
 */
abstract class Events implements IteratorAggregate
{
    /**
     * @return Iterator<Event>
     */
    #[ReturnTypeWillChange]
    abstract public function getIterator();

    abstract public function addEvent(Event $event): void;
}
