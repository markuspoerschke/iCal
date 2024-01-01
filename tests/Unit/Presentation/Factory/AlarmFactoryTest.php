<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation\Factory;

use DateInterval;
use DateTimeImmutable as PhpDateTimeImmutable;
use Eluceo\iCal\Domain\ValueObject\Alarm;
use Eluceo\iCal\Domain\ValueObject\Alarm\AbsoluteDateTimeTrigger;
use Eluceo\iCal\Domain\ValueObject\Alarm\AudioAction;
use Eluceo\iCal\Domain\ValueObject\Alarm\EmailAction;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Presentation\ContentLine;
use Eluceo\iCal\Presentation\Factory\AlarmFactory;
use PHPUnit\Framework\TestCase;

class AlarmFactoryTest extends TestCase
{
    public function testAudioAlarm()
    {
        $alarm = new Alarm(
            new AudioAction(),
            new AbsoluteDateTimeTrigger(new DateTime(new PhpDateTimeImmutable('2020-09-30 00:00:00'), false))
        );

        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VALARM',
            'ACTION:AUDIO',
            'TRIGGER;VALUE=DATE-TIME:20200930T000000',
            'END:VALARM',
        ]);

        $actual = (string) (new AlarmFactory())->createComponent($alarm);

        self::assertSame(
            $expected,
            trim($actual)
        );
    }

    public function testEmailAlarm()
    {
        $alarm = new Alarm(
            new EmailAction('Summary Text', 'Description Text'),
            new AbsoluteDateTimeTrigger(new DateTime(new PhpDateTimeImmutable('2020-09-30 00:00:00'), false))
        );

        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VALARM',
            'ACTION:EMAIL',
            'SUMMARY:Summary Text',
            'DESCRIPTION:Description Text',
            'TRIGGER;VALUE=DATE-TIME:20200930T000000',
            'END:VALARM',
        ]);

        $actual = (string) (new AlarmFactory())->createComponent($alarm);

        self::assertSame(
            $expected,
            trim($actual)
        );
    }

    public function testDisplayAlarm()
    {
        $alarm = new Alarm(
            new Alarm\DisplayAction('Description Text'),
            new AbsoluteDateTimeTrigger(new DateTime(new PhpDateTimeImmutable('2020-09-30 00:00:00'), false))
        );

        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VALARM',
            'ACTION:DISPLAY',
            'DESCRIPTION:Description Text',
            'TRIGGER;VALUE=DATE-TIME:20200930T000000',
            'END:VALARM',
        ]);

        $actual = (string) (new AlarmFactory())->createComponent($alarm);

        self::assertSame(
            $expected,
            trim($actual)
        );
    }

    public function testRelativeTrigger()
    {
        $alarm = new Alarm(
            new AudioAction(),
            new Alarm\RelativeTrigger(new DateInterval('P1D'))
        );

        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VALARM',
            'ACTION:AUDIO',
            'TRIGGER:P1D',
            'END:VALARM',
        ]);

        $actual = (string) (new AlarmFactory())->createComponent($alarm);

        self::assertSame(
            $expected,
            trim($actual)
        );
    }

    public function testRepeat()
    {
        $alarm = (new Alarm(
            new AudioAction(),
            new AbsoluteDateTimeTrigger(new DateTime(new PhpDateTimeImmutable('2020-09-30 00:00:00'), false))
        ))->withRepeat(3, new DateInterval('P1D'));

        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VALARM',
            'ACTION:AUDIO',
            'TRIGGER;VALUE=DATE-TIME:20200930T000000',
            'REPEAT:3',
            'DURATION:P1D',
            'END:VALARM',
        ]);

        $actual = (string) (new AlarmFactory())->createComponent($alarm);

        self::assertSame(
            $expected,
            trim($actual)
        );
    }
}
