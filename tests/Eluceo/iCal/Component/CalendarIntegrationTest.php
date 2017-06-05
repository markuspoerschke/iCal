<?php

namespace Eluceo\iCal\Component;

use PHPUnit\Framework\TestCase;

class CalendarIntegrationTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testExample3()
    {
        $timeZone = new \DateTimeZone('Europe/Berlin');

        // 1. Create new calendar
        $vCalendar = new \Eluceo\iCal\Component\Calendar('www.example.com');
        $vCalendar->setPublishedTTL('P1W');

        // 2. Create an event
        $vEvent = new \Eluceo\iCal\Component\Event('123456');
        $vEvent->setDtStart(new \DateTime('2012-12-31', $timeZone));
        $vEvent->setDtEnd(new \DateTime('2012-12-31', $timeZone));
        $vEvent->setNoTime(true);
        $vEvent->setIsPrivate(true);
        $vEvent->setSummary('New Year’s Eve');

        // Set recurrence rule
        $recurrenceRule = new \Eluceo\iCal\Property\Event\RecurrenceRule();
        $recurrenceRule->setFreq(\Eluceo\iCal\Property\Event\RecurrenceRule::FREQ_YEARLY);
        $recurrenceRule->setInterval(1);
        $vEvent->addRecurrenceRule($recurrenceRule);

        // Adding Timezone (optional)
        $vEvent->setUseTimezone(true);

        // 3. Add event to calendar
        $vCalendar->addComponent($vEvent);

        $lines = array(
            '/BEGIN:VCALENDAR/',
            '/VERSION:2\.0/',
            '/PRODID:www\.example\.com/',
            '/X-PUBLISHED-TTL:P1W/',
            '/BEGIN:VEVENT/',
            '/UID:123456/',
            '/DTSTART;VALUE=DATE:20121231/',
            '/SEQUENCE:0/',
            '/TRANSP:OPAQUE/',
            '/DTEND;VALUE=DATE:20130101/',
            '/SUMMARY:New Year’s Eve/',
            '/CLASS:PRIVATE/',
            '/RRULE:FREQ=YEARLY;INTERVAL=1/',
            '/X-MICROSOFT-CDO-ALLDAYEVENT:TRUE/',
            '/DTSTAMP:20\d{6}T\d{6}Z/',
            '/END:VEVENT/',
            '/END:VCALENDAR/',
        );

        foreach (explode("\n", $vCalendar->render()) as $key => $line)
        {
            $this->assertTrue(isset($lines[$key]), 'Too many lines... ' . $line);

            $this->assertRegExp($lines[$key], $line);
        }
    }

    /**
     * @coversNothing
     */
    public function testExample4b()
    {
        $timeZoneString = '/example.com/1.0.0-0/Europe/Berlin';

        // 1. Create new calendar
        $vCalendar = new \Eluceo\iCal\Component\Calendar('www.example.com');

        // 2. Create an event
        $vEvent = new \Eluceo\iCal\Component\Event('123456');
        $vEvent->setDtStart(new \DateTime('2012-11-11 13:00:00'));
        $vEvent->setDtEnd(new \DateTime('2012-11-11 14:30:00'));
        $vEvent->setSummary('Weekly lunch with Markus');

        // Set recurrence rule
        $recurrenceRule = new \Eluceo\iCal\Property\Event\RecurrenceRule();
        $recurrenceRule->setFreq(\Eluceo\iCal\Property\Event\RecurrenceRule::FREQ_WEEKLY);
        $recurrenceRule->setInterval(1);
        $vEvent->setRecurrenceRule($recurrenceRule);

        // Adding Timezone (optional)
        $vEvent->setUseTimezone(true);
        $vEvent->setTimezoneString($timeZoneString);

        // 3. Add event to calendar
        $vCalendar->addComponent($vEvent);

        $lines = array(
            '/BEGIN:VCALENDAR/',
            '/VERSION:2\.0/',
            '/PRODID:www\.example\.com/',
            '/BEGIN:VEVENT/',
            '/UID:123456/',
            '/DTSTART;TZID=\/example.com\/1.0.0-0\/Europe\/Berlin:20121111T130000/',
            '/SEQUENCE:0/',
            '/TRANSP:OPAQUE/',
            '/DTEND;TZID=\/example.com\/1.0.0-0\/Europe\/Berlin:20121111T143000/',
            '/SUMMARY:Weekly lunch with Markus/',
            '/CLASS:PUBLIC/',
            '/RRULE:FREQ=WEEKLY;INTERVAL=1/',
            '/DTSTAMP:20\d{6}T\d{6}Z/',
            '/END:VEVENT/',
            '/END:VCALENDAR/',
        );

        foreach (explode("\n", $vCalendar->render()) as $key => $line)
        {
            $this->assertTrue(isset($lines[$key]), 'Too many lines... ' . $line);

            $this->assertRegExp($lines[$key], $line);
        }
    }

    /**
     * This test was introduced because of a regression bug.
     *
     * @see https://github.com/markuspoerschke/iCal/issues/98
     *
     * @coversNothing
     */
    public function testRenderIsIdempotent()
    {
        $vCalendar = new \Eluceo\iCal\Component\Calendar('www.example.com');

        $vEvent = new \Eluceo\iCal\Component\Event('123456');
        $vEvent->setDtStart(new \DateTime('2012-12-24'));
        $vEvent->setDtEnd(new \DateTime('2012-01-04'));
        $vEvent->setNoTime(true);
        $vEvent->setSummary('Vacations');

        $vCalendar->addComponent($vEvent);

        $this->assertEquals($vCalendar->render(), $vCalendar->render());
    }
}
