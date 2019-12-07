<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation;

use Generator;

class Calendar extends Component
{
    /**
     * @var Component[]
     */
    private array $components = [];

    public static function createCalendar(array $components = [], array $properties = []): self
    {
        $new = static::create('VCALENDAR', $properties);
        array_walk($components, [$new, 'addComponent']);

        return $new;
    }

    private function addComponent(Component $component): void
    {
        $this->components[] = $component;
    }

    protected function getContentLinesGenerator(): Generator
    {
        yield from parent::getContentLinesGenerator();
        foreach ($this->components as $component) {
            yield from $component->getContentLines();
        }
    }
}
