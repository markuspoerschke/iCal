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

final class ContentLine
{
    public const LINE_SEPARATOR = "\r\n";
    private const LINE_LENGTH = 75;
    private string $line;

    public function __construct(string $line)
    {
        $this->line = $line;
    }

    public function __toString()
    {
        $string = $this->line;
        $lines = [];

        while (strlen($string) > static::LINE_LENGTH) {
            $lines[] = mb_strcut($string, 0, static::LINE_LENGTH, 'utf-8');
            $string = ' ' . mb_strcut($string, static::LINE_LENGTH, strlen($string), 'utf-8');
        }
        $lines[] = $string;

        return implode(self::LINE_SEPARATOR, $lines) . self::LINE_SEPARATOR;
    }
}
