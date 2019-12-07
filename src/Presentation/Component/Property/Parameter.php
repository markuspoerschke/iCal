<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property;

final class Parameter
{
    private string $name;
    private Value $value;

    private function __construct(string $name, Value $value)
    {
        $this->name = strtoupper($name);
        $this->value = $value;
    }

    public static function create(string $name, Value $value): self
    {
        return new static($name, $value);
    }

    public function __toString(): string
    {
        return $this->name . '=' . $this->value;
    }
}
