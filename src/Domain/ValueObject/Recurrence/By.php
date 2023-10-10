<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject\Recurrence;

use InvalidArgumentException;
use TypeError;

final class By
{
    private array $by;

    public function __construct($by)
    {
        if (!is_array($by)) {
            $by = [$by];
        }

        foreach ($by as $checkBy) {
            try {
                if (!in_array(get_class($checkBy), [
                    By\Second::class,
                    By\Minute::class,
                    By\Hour::class,
                    By\Day::class,
                    By\MonthDay::class,
                    By\Month::class,
                    By\YearDay::class,
                    By\SetPosition::class,
                    By\WeekNumber::class
                ])) {
                    $this->throwInvalid();
                }
            } catch (TypeError $e) {
                $this->throwInvalid();
            }
        }

        $this->by = $by;
    }

    private function throwInvalid(): void
    {
        throw new InvalidArgumentException('Values must be one of: Day, Hour, Minute, Month, MonthDay, Second, SetPosition, WeekNumber, YearDay');
    }

    public function __toString(): string
    {
        return implode(';', array_map(static function ($by) {
            return (string)$by;
        }, $this->by));
    }
}
