<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Unit\Domain\Entity;

use Eluceo\iCal\Domain\Entity\Todo;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TodoTest extends TestCase
{
    /**
     * @covers \Eluceo\iCal\Domain\Entity\Todo::setPercentComplete
     * @covers \Eluceo\iCal\Domain\Entity\Todo::getPercentComplete
     * @covers \Eluceo\iCal\Domain\Entity\Todo::hasPercentComplete
     */
    public function testSetAndGetPercentComplete(): void
    {
        $todo = new Todo();
        $todo->setPercentComplete(100);

        self::assertTrue($todo->hasPercentComplete());
        self::assertSame(100, $todo->getPercentComplete());
    }

    /**
     * @covers \Eluceo\iCal\Domain\Entity\Todo::setPercentComplete
     */
    public function testSetPercentCompleteRejectsInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new Todo())->setPercentComplete(101);
    }
}
