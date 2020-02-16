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

class Component
{
    public const LINE_SEPARATOR = "\r\n";

    /**
     * @var array<int, Property>
     */
    private array $properties = [];
    private string $componentName;

    private function __construct(string $componentName, array $properties)
    {
        $this->componentName = strtoupper($componentName);
        array_walk($properties, [$this, 'addProperty']);
    }

    /**
     * @param Property[] $properties
     */
    public static function create(string $componentName, array $properties = []): self
    {
        return new static($componentName, $properties);
    }

    public function withProperty(Property $property): self
    {
        $new = clone $this;
        $new->addProperty($property);

        return $new;
    }

    public function __toString(): string
    {
        return implode(
            Component::LINE_SEPARATOR,
            iterator_to_array($this->getContentLines(), false)
        );
    }

    protected function getContentLines(): Generator
    {
        yield ContentLine::fromString('BEGIN:' . $this->componentName);
        yield from $this->getContentLinesGenerator();
        yield ContentLine::fromString('END:' . $this->componentName);
    }

    protected function getContentLinesGenerator(): Generator
    {
        yield from array_map([ContentLine::class, 'fromString'], $this->properties);
    }

    private function addProperty(Property $property): self
    {
        $this->properties[] = $property;

        return $this;
    }
}
