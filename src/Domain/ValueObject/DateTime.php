<?php

namespace Eluceo\iCal\Domain\ValueObject;

use DateTimeZone as PhpDateTimeZone;

final class DateTime extends Timestamp
{
    private ?PhpDateTimeZone $dateTimeZone;
    private bool $hasTime = true;

    public function getDateTimeZone(): PhpDateTimeZone
    {
        return $this->dateTimeZone;
    }

    public function hasDateTimeZone(): bool
    {
        return $this->dateTimeZone !== null;
    }

    public function hasTime(): bool
    {
        return $this->hasTime;
    }
}
