<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use Eluceo\iCal\Presentation\Component\Property\Value;

/**
 * @see https://tools.ietf.org/html/rfc5545#section-3.3.11
 */
class TextValue extends Value
{
    /**
     * ESCAPED-CHAR as defined in section 3.3.11.
     */
    private const ESCAPED_CHARACTERS = [
        '\\' => '\\\\',
        ';' => '\\;',
        ',' => '\\,',
        "\n" => '\\n',
    ];

    /**
     * Non TSAFE-CHAR as described in section 3.3.11.
     */
    private const FORBIDDEN_CHARACTERS = [
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

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        $value = $this->value;

        $value = str_replace(array_keys(self::ESCAPED_CHARACTERS), array_values(self::ESCAPED_CHARACTERS), $value);
        $value = str_replace(self::FORBIDDEN_CHARACTERS, '', $value);

        return $value;
    }
}
