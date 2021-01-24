<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property;

final class Parameter
{
    private string $name;
    private Value $value;

    public function __construct(string $name, Value $value)
    {
        $this->name = strtoupper($name);
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->name . '=' . $this->value;
    }
}
