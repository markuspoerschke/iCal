<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) Markus Poerschke <markus@eluceo.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Factory\Property;

use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\StringValue;

class TimestampPropertyFactory
{
    private const FORMAT = 'Ymd\THis\Z';

    public function fromTimestamp(string $name, Timestamp $timestamp): Property
    {
        $dateTime = $timestamp->getDateTime()->setTimezone(new \DateTimeZone('UTC'));

        return Property::create(
            $name,
            StringValue::fromString($dateTime->format(static::FORMAT))
        );
    }
}
