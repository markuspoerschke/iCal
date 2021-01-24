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

use DateTimeInterface as PhpDateTime;
use DateTimeZone as PhpDateTimeZone;

final class DateTime extends Timestamp
{
    private bool $applyTimeZone;

    public function __construct(PhpDateTime $phpDateTime, bool $applyTimeZone)
    {
        parent::__construct($phpDateTime);
        $this->applyTimeZone = $applyTimeZone;
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function getDateTimeZone(): PhpDateTimeZone
    {
        return $this->getDateTime()->getTimezone();
    }

    public function hasDateTimeZone(): bool
    {
        return $this->applyTimeZone;
    }
}
