<?php

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
