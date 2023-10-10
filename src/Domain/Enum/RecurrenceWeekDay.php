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

final class RecurrenceWeekDay extends RecurrenceEnum
{
    public const SUNDAY = 'SU';
    public const MONDAY = 'MO';
    public const TUESDAY = 'TU';
    public const WEDNESDAY = 'WE';
    public const THURSDAY = 'TH';
    public const FRIDAY = 'FR';
    public const SATURDAY = 'SA';

    protected ?int $offset = null;


    public function __construct(string $value, ?int $offset = null)
    {
        parent::__construct($value);
        if ($offset !== null) {
            if ($offset < -53 || $offset > 53) {
                throw new \InvalidArgumentException('Day offsets must be between -53 and 53');
            }
            $this->offset = $offset;
        }
    }

    public static function sunday(?int $offset = null): self
    {
        return new self(self::SUNDAY, $offset);
    }

    public static function monday(?int $offset = null): self
    {
        return new self(self::MONDAY, $offset);
    }

    public static function tuesday(?int $offset = null): self
    {
        return new self(self::TUESDAY, $offset);
    }

    public static function wednesday(?int $offset = null): self
    {
        return new self(self::WEDNESDAY, $offset);
    }

    public static function thursday(?int $offset = null): self
    {
        return new self(self::THURSDAY, $offset);
    }

    public static function friday(?int $offset = null): self
    {
        return new self(self::FRIDAY, $offset);
    }

    public static function saturday(?int $offset = null): self
    {
        return new self(self::SATURDAY, $offset);
    }

    public function __toString(): string
    {
        return ($this->offset !== null ? (string)$this->offset : '') . parent::__toString();
    }
}
