<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2019 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use Eluceo\iCal\Domain\ValueObject\GeographicPosition;
use Eluceo\iCal\Presentation\Component\Property\Value;

class GeoValue extends Value
{
    private GeographicPosition $geographicPosition;

    private function __construct(GeographicPosition $geographicPosition)
    {
        $this->geographicPosition = $geographicPosition;
    }

    public static function fromGeographicPosition(GeographicPosition $geographicPosition): self
    {
        return new static($geographicPosition);
    }

    public function __toString(): string
    {
        return sprintf('%1.6F;%1.6F',
            number_format($this->geographicPosition->getLatitude(), 6),
            number_format($this->geographicPosition->getLongitude(), 6),
        );
    }
}
