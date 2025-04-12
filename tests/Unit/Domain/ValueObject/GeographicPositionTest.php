<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2025 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\ValueObject;

use Eluceo\iCal\Domain\ValueObject\GeographicPosition;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GeographicPositionTest extends TestCase
{
    #[DataProvider('provideInvalidPositions')]
    public function testConstructorDoesNotAcceptInvalidArguments(float $latitude, float $longitude)
    {
        static::expectException(InvalidArgumentException::class);
        new GeographicPosition($latitude, $longitude);
    }

    public static function provideInvalidPositions(): array
    {
        return [
            [-91, 0],
            [91, 0],
            [0, -181],
            [0, 181],
        ];
    }
}
