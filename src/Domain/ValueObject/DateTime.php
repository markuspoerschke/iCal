<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

use DateTimeZone as PhpDateTimeZone;

final class DateTime extends Timestamp
{
    private ?PhpDateTimeZone $dateTimeZone = null;

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function getDateTimeZone(): PhpDateTimeZone
    {
        return $this->dateTimeZone;
    }

    public function hasDateTimeZone(): bool
    {
        return $this->dateTimeZone !== null;
    }

    public function withDateTimeZone(PhpDateTimeZone $dateTimeZone): self
    {
        $new = clone $this;
        $new->dateTimeZone = $dateTimeZone;

        return $new;
    }
}
