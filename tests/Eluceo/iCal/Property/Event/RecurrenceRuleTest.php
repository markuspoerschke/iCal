<?php

namespace Eluceo\iCal\Property\Event;

use PHPUnit\Framework\TestCase;

class RecurrenceRuleTest extends TestCase
{
    /**
     * Example taken from http://www.kanzaki.com/docs/ical/rrule.html
     */
    public function testUntil()
    {
        $rule = new RecurrenceRule();
        $rule->setFreq(RecurrenceRule::FREQ_DAILY);
        $rule->setInterval(null);
        $rule->setUntil(new \DateTime('1997-12-24'));
        $this->assertEquals(
            'FREQ=DAILY;UNTIL=19971224T000000Z',
            $rule->getEscapedValue()
        );
    }
}
