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

use DateInterval;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Todo;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public static function provideGetSetPublishedTTLTestData(): array
    {
        return [
            [new DateInterval('P1W')],
            [null],
        ];
    }

    /**
     * @dataProvider provideGetSetPublishedTTLTestData
     *
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::getPublishedTTL
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::setPublishedTTL
     *
     * @param ?DateInterval $ttl
     */
    public function testGetSetPublishedTTL($ttl): void
    {
        $calendar = new Calendar();
        $calendar->setPublishedTTL($ttl);
        self::assertSame($calendar->getPublishedTTL(), $ttl);
    }

    /**
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::getCalName
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::setCalName
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::hasCalName
     */
    public function testGetSetCalName(): void
    {
        $calendar = new Calendar();

        self::assertFalse($calendar->hasCalName());

        $calendar->setCalName('Team Calendar');

        self::assertTrue($calendar->hasCalName());
        self::assertSame('Team Calendar', $calendar->getCalName());
    }

    /**
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::getCalDescription
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::setCalDescription
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::hasCalDescription
     */
    public function testGetSetCalDescription(): void
    {
        $calendar = new Calendar();

        self::assertFalse($calendar->hasCalDescription());

        $calendar->setCalDescription('Team availability calendar');

        self::assertTrue($calendar->hasCalDescription());
        self::assertSame('Team availability calendar', $calendar->getCalDescription());
    }

    /**
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::addTodo
     * @covers \Eluceo\iCal\Domain\Entity\Calendar::getTodos
     */
    public function testAddAndGetTodos(): void
    {
        $calendar = new Calendar();
        $todo = new Todo();

        $calendar->addTodo($todo);

        self::assertSame([$todo], $calendar->getTodos());
    }
}
