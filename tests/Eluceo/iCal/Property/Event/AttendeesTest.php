<?php

namespace Eluceo\iCal\Property\Event;

use Eluceo\iCal\Property;
use PHPUnit\Framework\TestCase;

class AttendeesTest extends TestCase
{
    public function testAdd()
    {
        $attendees = new Attendees();
        $attendees->add('MAILTO:joecool@host2.com', ['MEMBER' => "MAILTO:DEV-GROUP@host2.com"]);

        $this->assertContains('ATTENDEE;MEMBER="MAILTO:DEV-GROUP@host2.com":MAILTO:joecool@host2.com', $attendees->toLines());
    }

    public function testSetValue()
    {
        $attendees = new Attendees();
        $attendees->setValue([new Property('ATTENDEE', 'MAILTO:joecool@host2.com', ['MEMBER' => "MAILTO:DEV-GROUP@host2.com"])]);

        $this->assertContains('ATTENDEE;MEMBER="MAILTO:DEV-GROUP@host2.com":MAILTO:joecool@host2.com', $attendees->getValue()[0]->toLines());
    }

    public function testGetValue()
    {
        $attendees = new Attendees();

        $this->assertCount(0, $attendees->getValue());
    }

    public function testSetParamThrowsBadMethodCallException()
    {
        $this->expectExceptionMessage("Cannot call setParam on Attendees Property");
        $this->expectException(\BadMethodCallException::class);

        $attendees = new Attendees();
        $attendees->setParam('MAILTO', 'DEV-GROUP@host2.com');
    }

    public function testGetParamThrowsBadMethodCallException()
    {
        $this->expectExceptionMessage("Cannot call getParam on Attendees Property");
        $this->expectException(\BadMethodCallException::class);

        $attendees = new Attendees();
        $attendees->getParam('MAILTO');
    }
}
