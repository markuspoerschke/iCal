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

final class RecurrenceFrequency extends RecurrenceEnum
{
    public const SECONDLY = 'secondly';
    public const MINUTELY = 'minutely';
    public const HOURLY = 'hourly';
    public const DAILY = 'daily';
    public const WEEKLY = 'weekly';
    public const MONTHLY = 'monthly';
    public const YEARLY = 'yearly';

    public static function secondly(): self
    {
        return new self(self::SECONDLY);
    }

    public static function minutely(): self
    {
        return new self(self::MINUTELY);
    }

    public static function hourly(): self
    {
        return new self(self::HOURLY);
    }

    public static function daily(): self
    {
        return new self(self::DAILY);
    }

    public static function weekly(): self
    {
        return new self(self::WEEKLY);
    }

    public static function monthly(): self
    {
        return new self(self::MONTHLY);
    }

    public function yearly(): self
    {
        return new self(self::YEARLY);
    }
}
