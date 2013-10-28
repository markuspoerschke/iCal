<?php

namespace Eluceo\iCal\Property\Event;

use Eluceo\iCal\Component\Event;
use Eluceo\iCal\Property\ValueInterface;
use Eluceo\iCal\ParameterBag;

class RecurrenceRule implements ValueInterface
{
    const FREQ_YEARLY = 'YEARLY';
    const FREQ_MONTHLY = 'MONTHLY';
    const FREQ_WEEKLY = 'WEEKLY';
    const FREQ_DAILY = 'DAILY';

    /**
     * The frequency of an Event
     *
     * @var string
     */
    protected $freq = self::FREQ_YEARLY;

    /**
     * @var null|int
     */
    protected $interval = 1;

    /**
     * @var null|int
     */
    protected $count = null;

    /**
     * Return the value of the Property as an escaped string.
     *
     * Escape values as per RFC 2445. See http://www.kanzaki.com/docs/ical/text.html
     *
     * @return string
     */
    public function getEscapedValue()
    {
        return $this->buildParameterBag()->toString();
    }

    /**
     * @return ParameterBag
     */
    protected function buildParameterBag()
    {
        $parameterBag = new ParameterBag();

        $parameterBag->setParam('FREQ', $this->freq);

        if (null !== $this->interval) {
            $parameterBag->setParam('INTERVAL', $this->interval);
        }

        if (null !== $this->count) {
            $parameterBag->setParam('COUNT', $this->count);
        }

        return $parameterBag;
    }

    /**
     * @param int|null $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int|null
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param string $freq
     * @throws \Exception
     */
    public function setFreq($freq)
    {
        if (self::FREQ_YEARLY === $freq || self::FREQ_MONTHLY === $freq ||
            self::FREQ_WEEKLY === $freq || self::FREQ_DAILY === $freq) {
            $this->freq = $freq;
        } else {
            throw new \InvalidArgumentException("The Frequency {$freq} is not supported.");
        }
    }

    /**
     * @return string
     */
    public function getFreq()
    {
        return $this->freq;
    }

    /**
     * @param int|null $interval
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return int|null
     */
    public function getInterval()
    {
        return $this->interval;
    }
}
