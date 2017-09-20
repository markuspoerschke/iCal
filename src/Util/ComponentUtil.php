<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) Markus Poerschke <markus@eluceo.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Util;

class ComponentUtil
{
    /**
     * Folds a single line.
     *
     * According to RFC 5545, all lines longer than 75 characters should be folded
     *
     * @see https://tools.ietf.org/html/rfc5545#section-5
     * @see https://tools.ietf.org/html/rfc5545#section-3.1
     *
     * @param $string
     *
     * @return array
     */
    public static function fold($string)
    {
        $lines = [];
        while (strlen($string) > 0) {
            if (strlen($string) > 75) {
                $lines[] = mb_strcut($string, 0, 75, 'utf-8');
                $string = ' ' . mb_strcut($string, 75, strlen($string), 'utf-8');
            } else {
                $lines[] = $string;
                $string = '';
                break;
            }
        }
        return $lines;
    }
}
