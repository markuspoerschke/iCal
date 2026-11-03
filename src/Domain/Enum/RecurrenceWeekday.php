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
 * Weekday for recurrence rules.
 *
 * @see https://tools.ietf.org/html/rfc5545#section-3.3.10
 */
final class RecurrenceWeekday
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    private static ?self $sunday = null;
    private static ?self $monday = null;
    private static ?self $tuesday = null;
    private static ?self $wednesday = null;
    private static ?self $thursday = null;
    private static ?self $friday = null;
    private static ?self $saturday = null;

    public static function SUNDAY(): self
    {
        return self::$sunday ??= new self('SU');
    }

    public static function MONDAY(): self
    {
        return self::$monday ??= new self('MO');
    }

    public static function TUESDAY(): self
    {
        return self::$tuesday ??= new self('TU');
    }

    public static function WEDNESDAY(): self
    {
        return self::$wednesday ??= new self('WE');
    }

    public static function THURSDAY(): self
    {
        return self::$thursday ??= new self('TH');
    }

    public static function FRIDAY(): self
    {
        return self::$friday ??= new self('FR');
    }

    public static function SATURDAY(): self
    {
        return self::$saturday ??= new self('SA');
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
