<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation;

use Eluceo\iCal\Presentation\Component\Property;
use Generator;

class Calendar extends Component
{
    /**
     * @var iterable<Component>
     */
    private iterable $components = [];

    /**
     * @param iterable<Component> $components
     * @param Property[]          $properties
     */
    public static function createCalendar(iterable $components = [], array $properties = []): self
    {
        $new = new self('VCALENDAR', $properties);
        $new->components = $components;

        return $new;
    }

    protected function getContentLinesGenerator(): Generator
    {
        yield from parent::getContentLinesGenerator();
        foreach ($this->components as $component) {
            yield from $component->getContentLines();
        }
    }
}
