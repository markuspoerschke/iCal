<?php

namespace Eluceo\iCal;

class ComponentTest extends \PHPUnit_Framework_TestCase
{
    public function testFoldWithMultibyte()
    {
        $input = "x" . str_repeat("あいうえお", 5);

        $vCalendar = new \Eluceo\iCal\Component\Calendar('www.example.com');
        $vEvent = new \Eluceo\iCal\Component\Event();
        $vEvent->setDtStart(new \DateTime('2012-12-24'));
        $vEvent->setDtEnd(new \DateTime('2012-12-24'));
        $vEvent->setDescription($input);
        $vCalendar->addEvent($vEvent);

        $output = $vCalendar->render();
        $output = preg_replace('/\r\n /u', '', $output);
        $this->assertContains($input, $output);
    }
}
