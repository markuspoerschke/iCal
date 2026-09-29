<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\Enum;

/**
 * Frequency for recurrence rules.
 *
 * @see https://tools.ietf.org/html/rfc5545#section-3.3.10
 */
final class RecurrenceFrequency
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    private static ?self $secondly = null;
    private static ?self $minutely = null;
    private static ?self $hourly = null;
    private static ?self $daily = null;
    private static ?self $weekly = null;
    private static ?self $monthly = null;
    private static ?self $yearly = null;

    public static function SECONDLY(): self
    {
        return self::$secondly ??= new self('SECONDLY');
    }

    public static function MINUTELY(): self
    {
        return self::$minutely ??= new self('MINUTELY');
    }

    public static function HOURLY(): self
    {
        return self::$hourly ??= new self('HOURLY');
    }

    public static function DAILY(): self
    {
        return self::$daily ??= new self('DAILY');
    }

    public static function WEEKLY(): self
    {
        return self::$weekly ??= new self('WEEKLY');
    }

    public static function MONTHLY(): self
    {
        return self::$monthly ??= new self('MONTHLY');
    }

    public static function YEARLY(): self
    {
        return self::$yearly ??= new self('YEARLY');
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
