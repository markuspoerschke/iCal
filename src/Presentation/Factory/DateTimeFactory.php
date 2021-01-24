<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Factory;

use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\PointInTime;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\DateTimeValue;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;

class DateTimeFactory
{
    /**
     * @param Timestamp|DateTime $pointInTime
     */
    public function createProperty(string $propertyName, PointInTime $pointInTime): Property
    {
        return new Property(
            $propertyName,
            new DateTimeValue($pointInTime),
            $this->getParameters($pointInTime)
        );
    }

    /**
     * @return array<Property\Parameter>
     */
    private function getParameters(PointInTime $pointInTime): array
    {
        if ($pointInTime instanceof DateTime && $pointInTime->hasDateTimeZone()) {
            return [
                new Property\Parameter('TZID', new TextValue($pointInTime->getDateTimeZone()->getName())),
            ];
        }

        return [];
    }
}
