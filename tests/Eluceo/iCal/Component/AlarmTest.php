<?php

namespace Eluceo\iCal\Component;

use PHPUnit\Framework\TestCase;

class AlarmTest extends TestCase
{
    public function testGetAction()
    {
        $alarm = new Alarm();
        $alarm->setAction('AUDIO');

        $this->assertSame('AUDIO', $alarm->getAction());
        $this->assertSame('ACTION', $alarm->buildPropertyBag()->get('ACTION')->getName());
    }

    public function testGetRepeat()
    {
        $alarm = new Alarm();
        $alarm->setRepeat(4);

        $this->assertSame(4, $alarm->getRepeat());
        $this->assertSame('REPEAT', $alarm->buildPropertyBag()->get('REPEAT')->getName());
    }

    public function testGetDuration()
    {
        $alarm = new Alarm();
        $alarm->setDuration('PT5M');

        $this->assertSame('PT5M', $alarm->getDuration());
        $this->assertSame('DURATION', $alarm->buildPropertyBag()->get('DURATION')->getName());
    }

    public function testGetDescription()
    {
        $alarm = new Alarm();
        $alarm->setDescription("Last draft of the new novel is to be completed for the editor's proof today.");

        $this->assertSame("Last draft of the new novel is to be completed for the editor's proof today.", $alarm->getDescription());
        $this->assertSame('DESCRIPTION', $alarm->buildPropertyBag()->get('DESCRIPTION')->getName());
    }

    public function testGetAttendee()
    {
        $alarm = new Alarm();
        $alarm->setAttendee('ATTENDEE;MEMBER="MAILTO:DEV-GROUP@host2.com": MAILTO:joecool@host2.com');

        $this->assertSame('ATTENDEE;MEMBER="MAILTO:DEV-GROUP@host2.com": MAILTO:joecool@host2.com', $alarm->getAttendee());
        $this->assertSame('ATTENDEE', $alarm->buildPropertyBag()->get('ATTENDEE')->getName());
    }

    public function testGetTrigger()
    {
        $alarm = new Alarm();
        $alarm->setTrigger('-P15M');

        $this->assertSame('-P15M', $alarm->getTrigger());
        $this->assertSame('TRIGGER', $alarm->buildPropertyBag()->get('TRIGGER')->getName());
    }
}
