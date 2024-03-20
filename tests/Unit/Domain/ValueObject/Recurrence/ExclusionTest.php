<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\ValueObject\Recurrence;

use DateTime as PhpDateTime;
use PHPUnit\Framework\TestCase;
use Eluceo\iCal\Domain\ValueObject\Recurrence\Exclusion;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use InvalidArgumentException;

class ExclusionTest extends TestCase
{
    public function testConstructorWithSingleExclusion(): void
    {
        $exclusion = new Exclusion([new DateTime(
            new PhpDateTime('2023-12-31T12:00:00'),
            true
        )]);

        $this->assertInstanceOf(Exclusion::class, $exclusion);
        $this->assertSame('20231231T120000', $exclusion->__toString());
    }

    public function testConstructorWithMultipleExclusions(): void
    {
        $exclusions = new Exclusion([
            new DateTime(new PhpDateTime('2023-12-31T12:00:00'), true),
            new DateTime(new PhpDateTime('2023-12-30T14:30:00'), true),
        ]);

        $this->assertInstanceOf(Exclusion::class, $exclusions);
        $this->assertSame('20231231T120000,20231230T143000', $exclusions->__toString());
    }

    public function testConstructorWithInvalidExclusionValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Values must be DateTime objects');

        new Exclusion([new DateTime(new PhpDateTime('2023-12-31T12:00:00'), true), 'invalidValue']);
    }
}
