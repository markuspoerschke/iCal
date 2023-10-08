<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Enum;

use InvalidArgumentException;
use ReflectionClass;

abstract class RecurrenceEnum
{
    protected string $value;

    public function __construct(string $value)
    {
        $constants = (new ReflectionClass(static::class))->getConstants();
        if (!in_array($value, $constants, true)) {
            $allowedValues = implode(', ', $constants);
            throw new InvalidArgumentException(
                "Value must be one of: {$allowedValues}"
            );
        }
        $this->value = $value;
    }

    public function __toString(): string
    {
        return strtoupper($this->value);
    }
}
