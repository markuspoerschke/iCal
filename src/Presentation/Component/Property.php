<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component;

use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value;

class Property
{
    private string $name;

    /**
     * @var array<int, Parameter>
     */
    private array $parameters = [];

    private Value $value;

    /**
     * @param Parameter[] $parameters
     */
    public function __construct(string $name, Value $value, array $parameters = [])
    {
        $this->name = strtoupper($name);
        $this->value = $value;
        foreach ($parameters as $parameter) {
            $this->addParameter($parameter);
        }
    }

    public function __toString(): string
    {
        $string = $this->name;

        if (count($this->parameters) > 0) {
            $string .= ';' . implode(';', array_map('strval', $this->parameters));
        }

        return $string . ':' . $this->value;
    }

    private function addParameter(Parameter $parameter): void
    {
        $this->parameters[] = $parameter;
    }
}
