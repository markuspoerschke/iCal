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

use InvalidArgumentException;

final class GeographicPosition
{
    private float $latitude;
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        if ($this->latitude < -90 || $this->latitude > 90) {
            throw new InvalidArgumentException("The geographical latitude must be a value between -90 and 90 degrees. '{$this->latitude}' was given.");
        }

        if ($this->longitude < -180 || $this->longitude > 180) {
            throw new InvalidArgumentException("The geographical longitude must be a value between -180 and 180 degrees. '{$this->longitude}' was given.");
        }
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
