<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2026 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Unit\Presentation\Factory;

use DateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\Entity\Todo;
use Eluceo\iCal\Domain\Enum\TodoStatus;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;
use Eluceo\iCal\Presentation\ContentLine;
use Eluceo\iCal\Presentation\Factory\TodoFactory;
use PHPUnit\Framework\TestCase;

class TodoFactoryTest extends TestCase
{
    public function testMinimalTodo(): void
    {
        $currentTime = new Timestamp(
            DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                '2019-11-10 11:22:33',
                new DateTimeZone('UTC')
            )
        );

        $todo = (new Todo(new UniqueIdentifier('todo1')))->touch($currentTime);

        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VTODO',
            'UID:todo1',
            'DTSTAMP:20191110T112233Z',
            'END:VTODO',
            '',
        ]);

        self::assertSame($expected, (string) (new TodoFactory())->createComponent($todo));
    }

    public function testTodoWithStatusProgressAndDates(): void
    {
        $todo = (new Todo(new UniqueIdentifier('todo1')))
            ->touch(new Timestamp(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2019-11-10 11:22:33', new DateTimeZone('UTC'))))
            ->setSummary('Prepare release')
            ->setStatus(TodoStatus::IN_PROCESS())
            ->setPercentComplete(50)
            ->setStart(new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-24')))
            ->setDue(new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i', '2030-12-24 13:45'), false))
            ->setCompletedAt(new Timestamp(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2030-12-24 14:00:00', new DateTimeZone('UTC'))));

        self::assertTodoRendersCorrect($todo, [
            'SUMMARY:Prepare release',
            'DTSTART;VALUE=DATE:20301224',
            'DUE:20301224T134500',
            'COMPLETED:20301224T140000Z',
            'STATUS:IN-PROCESS',
            'PERCENT-COMPLETE:50',
        ]);
    }

    private static function assertTodoRendersCorrect(Todo $todo, array $expected): void
    {
        $component = (string) (new TodoFactory())->createComponent($todo);

        foreach ($expected as $expectedLine) {
            self::assertStringContainsString($expectedLine, $component);
        }
    }
}
