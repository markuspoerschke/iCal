<?php

namespace Eluceo\iCal\Property\Event;

use PHPUnit\Framework\TestCase;

class RecurrenceIdTest extends TestCase
{
    public function testConstructorOnDateTime()
    {
        $this->assertInstanceOf(RecurrenceId::class, new RecurrenceId(new \DateTime('now', new \DateTimeZone('Asia/Taipei'))));
    }

    public function testConstructorOnNullDateTime()
    {
        $this->assertInstanceOf(RecurrenceId::class, new RecurrenceId());
    }

    public function testApplyTimeSettings()
    {
        $recurrenceId = new RecurrenceId();
        $recurrenceId->applyTimeSettings();

        $this->assertStringContainsString(date('Ymd'), $recurrenceId->getValue()->getValue());
    }

    public function testApplyTimeSettingsOnRange()
    {
        $recurrenceId = new RecurrenceId();
        $recurrenceId->setRange('RANGE=THISANDPRIOR:19980401T133000Z');
        $recurrenceId->applyTimeSettings();

        $this->assertStringContainsString(date('Ymd'), $recurrenceId->getValue()->getValue());
    }

    public function testApplyTimeSettingsOnDefaultParams()
    {
        $recurrenceId = new RecurrenceId();
        $recurrenceId->applyTimeSettings(true, true, true, 'Europe/Berlin');

        $this->assertStringContainsString(date('Ymd'), $recurrenceId->getValue()->getValue());
        $this->assertSame(date('Ymd'), $recurrenceId->getValue()->getValue());
    }

    public function testGetDatetime()
    {
        $recurrenceId = new RecurrenceId(new \DateTime('now', new \DateTimeZone('Europe/Berlin')));

        $this->assertInstanceOf(\DateTime::class, $recurrenceId->getDatetime());
        $this->assertSame('Europe/Berlin', $recurrenceId->getDatetime()->getTimeZone()->getName());
    }

    public function testSetDatetime()
    {
        $recurrenceId = new RecurrenceId();
        $recurrenceId->setDatetime(new \DateTime('now', new \DateTimeZone('Asia/Taipei')));

        $this->assertInstanceOf(\DateTime::class, $recurrenceId->getDatetime());
        $this->assertSame('Asia/Taipei', $recurrenceId->getDatetime()->getTimeZone()->getName());
    }

    public function testSetRange()
    {
        $recurrenceId = new RecurrenceId();
        $recurrenceId->setRange('RANGE=THISANDPRIOR:19980401T133000Z');

        $this->assertSame('RANGE=THISANDPRIOR:19980401T133000Z', $recurrenceId->getRange());
    }

    public function testGetRange()
    {
        $recurrenceId = new RecurrenceId();

        $this->assertNull($recurrenceId->getRange());
    }

    public function testToLines()
    {
        $recurrenceId = new RecurrenceId();
        $recurrenceId->setValue('value1');

        $this->assertSame(['RECURRENCE-ID:value1'], $recurrenceId->toLines());
    }

    public function testToLinesThrowsException()
    {
        $this->expectExceptionMessage("The value must implement the ValueInterface.");
        $this->expectException(\Exception::class);

        $recurrenceId = new RecurrenceId();

        $recurrenceId->toLines();
    }
}
