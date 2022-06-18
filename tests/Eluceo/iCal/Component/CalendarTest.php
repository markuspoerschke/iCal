<?php

namespace Eluceo\iCal\Component;

use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public function testConstructorThrowsUnexpectedValueException()
    {
        $this->expectExceptionMessage("PRODID cannot be empty");
        $this->expectException(\UnexpectedValueException::class);

        new Calendar(null);
    }

    public function testSetMethod()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setMethod('REQUEST');

        $this->assertSame('REQUEST', $calendar->getMethod());
        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nMETHOD:REQUEST\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testSetName()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setName('calendar_name');

        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nX-WR-CALNAME:calendar_name\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testSetDescription()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setDescription("Last draft of the new novel is to be completed for the editor's proof today.");

        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nX-WR-CALDESC:Last draft of the new novel is to be completed for the editor'\r\n s proof today.\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testSetTimezone()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setTimezone('America/Los_Angeles');

        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nX-WR-TIMEZONE:America/Los_Angeles\r\nBEGIN:VTIMEZONE\r\nTZID:America/Los_Angeles\r\nX-LIC-LOCATION:America/Los_Angeles\r\nEND:VTIMEZONE\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testSetTimezoneOnTimezone()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setTimezone(new Timezone('America/Los_Angeles'));

        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nX-WR-TIMEZONE:America/Los_Angeles\r\nBEGIN:VTIMEZONE\r\nTZID:America/Los_Angeles\r\nX-LIC-LOCATION:America/Los_Angeles\r\nEND:VTIMEZONE\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testSetCalendarColor()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setCalendarColor('#000000');

        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nX-APPLE-CALENDAR-COLOR:#000000\r\nX-OUTLOOK-COLOR:#000000\r\nX-FUNAMBOL-COLOR:#000000\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testSetCalendarScale()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setCalendarScale('GREGORIAN');

        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nCALSCALE:GREGORIAN\r\nX-MICROSOFT-CALSCALE:GREGORIAN\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testSetForceInspectOrOpen()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setForceInspectOrOpen('TRUE');

        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nX-MS-OLK-FORCEINSPECTOROPEN:TRUE\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testSetCalId()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setCalId('Berkeleyside');

        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nX-WR-RELCALID:Berkeleyside\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testSetPublishedTTL()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->setPublishedTTL('PT1H');

        $this->assertSame("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ABC Corporation//NONSGML My Product//EN\r\nX-PUBLISHED-TTL:PT1H\r\nEND:VCALENDAR", $calendar->render());
    }

    public function testGetProdId()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');

        $this->assertSame('-//ABC Corporation//NONSGML My Product//EN', $calendar->getProdId());
    }

    public function testAddEvent()
    {
        $calendar = new Calendar('-//ABC Corporation//NONSGML My Product//EN');
        $calendar->addEvent(new Event('unique_id'));

        $this->assertStringContainsString("unique_id", $calendar->render());
    }
}
