<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use Eluceo\iCal\Presentation\Component\Property\Value;

/**
 * @see https://tools.ietf.org/html/rfc5545#section-3.3.11
 */
final class TextValue extends Value
{
    private const CONTROL_CHARACTERS = [
        "\x00",
        "\x01",
        "\x02",
        "\x03",
        "\x04",
        "\x05",
        "\x06",
        "\x07",
        "\x08",
        "\x09",
        "\x0b",
        "\x0c",
        "\x0d",
        "\x0e",
        "\x0f",
        "\x10",
        "\x11",
        "\x12",
        "\x13",
        "\x14",
        "\x15",
        "\x16",
        "\x17",
        "\x18",
        "\x19",
        "\x1a",
        "\x1b",
        "\x1c",
        "\x1d",
        "\x1e",
        "\x1f",
        "\x7f",
    ];
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        $value = $this->value;
        $value = str_replace('\\', '\\\\', $value);
        $value = str_replace(',', '\\,', $value);
        $value = str_replace(';', '\\;', $value);
        $value = str_replace("\n", '\\n', $value);

        // escape double quotes
        //  even if it is not mentioned in the RFC,
        //  most calendar software will interpret \" as a double quote
        //  this is an undefined behavior, since double quotes can be
        //  used to escape the characters mentioned above
        $value = str_replace('"', '\\"', $value);

        // remove forbidden characters
        $value = str_replace(static::CONTROL_CHARACTERS, '', $value);

        return $value;
    }

    public static function fromString(string $value): self
    {
        return new static($value);
    }
}
