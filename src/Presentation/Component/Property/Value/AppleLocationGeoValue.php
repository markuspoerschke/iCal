<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

final class AppleLocationGeoValue extends GeoValue
{
    public function __toString(): string
    {
        return sprintf('geo:%1.6F,%1.6F',
            number_format($this->geographicPosition->getLatitude(), 6),
            number_format($this->geographicPosition->getLongitude(), 6),
        );
    }
}
