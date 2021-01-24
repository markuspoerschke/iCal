<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation;

use Eluceo\iCal\Presentation\Component\Property;
use Generator;
use IteratorAggregate;

class Component implements IteratorAggregate
{
    private string $componentName;

    /**
     * @var Property[]
     */
    private array $properties = [];

    /**
     * @var iterable<Component>
     */
    private iterable $components = [];

    /**
     * @param Property[]          $properties
     * @param iterable<Component> $components
     */
    public function __construct(string $componentName, array $properties = [], iterable $components = [])
    {
        $this->componentName = $componentName;
        $this->properties = $properties;
        $this->components = $components;
    }

    public function withProperty(Property $property): self
    {
        $new = clone $this;
        $new->properties[] = $property;

        return $new;
    }

    public function __toString(): string
    {
        return implode(
            '',
            iterator_to_array($this->getContentLines(), false)
        );
    }

    public function getIterator()
    {
        return $this->getContentLines();
    }

    protected function getContentLines(): Generator
    {
        yield new ContentLine('BEGIN:' . $this->componentName);
        yield from $this->getContentLinesGenerator();
        yield new ContentLine('END:' . $this->componentName);
    }

    protected function getContentLinesGenerator(): Generator
    {
        foreach ($this->properties as $property) {
            yield new ContentLine((string) $property);
        }

        foreach ($this->components as $component) {
            yield from $component->getContentLines();
        }
    }
}
