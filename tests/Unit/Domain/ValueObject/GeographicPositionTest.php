<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\ValueObject;

use Eluceo\iCal\Domain\ValueObject\GeographicPosition;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GeographicPositionTest extends TestCase
{
    /**
     * @dataProvider provideInvalidPositions
     */
    public function testConstructorDoesNotAcceptInvalidArguments(float $latitude, float $longitude)
    {
        static::expectException(InvalidArgumentException::class);
        new GeographicPosition($latitude, $longitude);
    }

    public function provideInvalidPositions(): Generator
    {
        yield [-91, 0];
        yield [91, 0];
        yield [0, -181];
        yield [0, 181];
    }
}
