<?php

namespace Eluceo\iCal\Domain\ValueObject;

use DateTimeInterface as PhpDateTimeInterface;
use DateTimeImmutable as PhpDateTimeImmutable;
use DateTimeZone as PhpDateTimeZone;


class Timestamp
{
    private PhpDateTimeImmutable $dateTime;

    private function __construct(PhpDateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public static function fromDateTimeInterface(PhpDateTimeInterface $dateTime): self
    {
        return new static(
            PhpDateTimeImmutable::createFromFormat(
                PhpDateTimeInterface::ATOM,
                $dateTime->format(PhpDateTimeInterface::ATOM), $dateTime->getTimezone()
            )
        );
    }

    public static function fromCurrentTime(): self
    {
        return static::fromDateTimeInterface(new PhpDateTimeImmutable());
    }

    public function getDateTime(): PhpDateTimeImmutable
    {
        return $this->dateTime;
    }
}
