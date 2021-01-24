<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;
use Eluceo\iCal\Domain\Enum\TimeZoneTransitionType;
use Eluceo\iCal\Util\DateTimeImmutableFactory;

class TimeZoneTransition
{
    private DateTimeImmutable $fromDateTime;

    /**
     * Offset in seconds.
     */
    private int $offsetFrom;

    /**
     * Offset in seconds.
     */
    private int $offsetTo;

    private string $timeZoneName;

    private TimeZoneTransitionType $type;

    public function __construct(
        TimeZoneTransitionType $type,
        DateTimeInterface $fromDateTime,
        int $offsetFrom,
        int $offsetTo,
        string $timeZoneName)
    {
        $this->type = $type;
        $this->fromDateTime = DateTimeImmutableFactory::createFromInterface($fromDateTime);
        $this->offsetFrom = $offsetFrom;
        $this->offsetTo = $offsetTo;
        $this->timeZoneName = $timeZoneName;
    }

    public function getFromDateTime(): DateTimeImmutable
    {
        return $this->fromDateTime;
    }

    public function getOffsetFrom(): int
    {
        return $this->offsetFrom;
    }

    public function getOffsetTo(): int
    {
        return $this->offsetTo;
    }

    public function getTimeZoneName(): string
    {
        return $this->timeZoneName;
    }

    public function getType(): TimeZoneTransitionType
    {
        return $this->type;
    }
}
