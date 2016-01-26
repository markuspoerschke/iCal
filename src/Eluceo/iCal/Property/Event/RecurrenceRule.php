<?php

namespace Eluceo\iCal\Property\Event;

use Eluceo\iCal\Property\ValueInterface;
use Eluceo\iCal\Property\DateTimeProperty;
use Eluceo\iCal\ParameterBag;
use InvalidArgumentException;

/**
 * Implementation of Recurrence Rule.
 *
 * @see http://www.ietf.org/rfc/rfc2445.txt 3.3.10.  Recurrence Rule
 */
class RecurrenceRule implements ValueInterface
{
    const FREQ_YEARLY = 'YEARLY';
    const FREQ_MONTHLY = 'MONTHLY';
    const FREQ_WEEKLY = 'WEEKLY';
    const FREQ_DAILY = 'DAILY';

    const WEEKDAY_SUNDAY = "SU";
    const WEEKDAY_MONDAY = "MO";
    const WEEKDAY_TUESDAY = "TU";
    const WEEKDAY_WEDNESDAY = "WE";
    const WEEKDAY_THURSDAY = "TH";
    const WEEKDAY_FRIDAY = "FR";
    const WEEKDAY_SATURDAY = "SA";

    /**
     * The frequency of an Event.
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
     * @var null|\DateTime
     */
    protected $until = null;

    /**
     * @var null|string
     */
    protected $wkst;

    /**
     * @var array
     */
    protected $byMonth = array();

    /**
     * @var array
     */
    protected $byWeekNo = array();

    /**
     * @var array
     */
    protected $byYearDay = array();

    /**
     * @var array
     */
    protected $byMonthDay = array();

    /**
     * @var array
     */
    protected $byDay = array();

    /**
     * @var array
     */
    protected $byHour = array();

    /**
     * @var array
     */
    protected $byMinute = array();

    /**
     * @var array
     */
    protected $bySecond = array();

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

        if (null != $this->until) {
            $parameterBag->setParam('UNTIL', $this->until->format('Ymd\THis\Z'));
        }

        if (null !== $this->wkst) {
            $parameterBag->setParam('WKST', $this->wkst);
        }

        if (!empty($this->byMonth)) {
            $parameterBag->setParam('BYMONTH', $this->byMonth);
        }

        if (!empty($this->byWeekNo)) {
            $parameterBag->setParam('BYWEEKNO', $this->byWeekNo);
        }

        if (!empty($this->byYearDay)) {
            $parameterBag->setParam('BYYEARDAY', $this->byYearDay);
        }

        if (!empty($this->byMonthDay)) {
            $parameterBag->setParam('BYMONTHDAY', $this->byMonthDay);
        }

        if (!empty($this->byDay)) {
            $parameterBag->setParam('BYDAY', $this->byDay);
        }

        if (!empty($this->byHour)) {
            $parameterBag->setParam('BYHOUR', $this->byHour);
        }

        if (!empty($this->byMinute)) {
            $parameterBag->setParam('BYMINUTE', $this->byMinute);
        }

        if (!empty($this->bySecond)) {
            $parameterBag->setParam('BYSECOND', $this->bySecond);
        }

        return $parameterBag;
    }

    /**
     * @param int|null $count
     *
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param \DateTime|null $until
     *
     * @return $this
     */
    public function setUntil(\DateTime $until = null)
    {
        $this->until = $until;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * The FREQ rule part identifies the type of recurrence rule.  This
     * rule part MUST be specified in the recurrence rule.  Valid values
     * include.
     *
     * SECONDLY, to specify repeating events based on an interval of a second or more;
     * MINUTELY, to specify repeating events based on an interval of a minute or more;
     * HOURLY, to specify repeating events based on an interval of an hour or more;
     * DAILY, to specify repeating events based on an interval of a day or more;
     * WEEKLY, to specify repeating events based on an interval of a week or more;
     * MONTHLY, to specify repeating events based on an interval of a month or more;
     * YEARLY, to specify repeating events based on an interval of a year or more.
     *
     * @param string $freq
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setFreq($freq)
    {
        if (self::FREQ_YEARLY === $freq || self::FREQ_MONTHLY === $freq
            || self::FREQ_WEEKLY === $freq
            || self::FREQ_DAILY === $freq
        ) {
            $this->freq = $freq;
        } else {
            throw new \InvalidArgumentException("The Frequency {$freq} is not supported.");
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getFreq()
    {
        return $this->freq;
    }

    /**
     * The INTERVAL rule part contains a positive integer representing at
     * which intervals the recurrence rule repeats.
     *
     * @param int|null $interval
     *
     * @return $this
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * The WKST rule part specifies the day on which the workweek starts.
     * Valid values are MO, TU, WE, TH, FR, SA, and SU.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setWkst($value)
    {
        $this->wkst = $value;

        return $this;
    }

    /**
     * The BYMONTH rule part specifies a COMMA-separated list of months of the year.
     * Valid value is an array with values of 1 to 12.
     *
     * @param array $value
     *
     * @throws InvalidArgumentException
     *
     * @return $this
     */
    public function setByMonth($value)
    {
        if (!$this->piecesAreInRange($value, 12)) {
            throw new InvalidArgumentException('Invalid value for BYMONTH');
        }

        $this->byMonth = $value;

        return $this;
    }

    /**
     * The BYWEEKNO rule part specifies a COMMA-separated list of ordinals specifying weeks of the year.
     * Valid value is an array with values of 1 to 53 or -53 to -1.
     *
     * @param array $value
     *
     * @return $this
     */
    public function setByWeekNo($value)
    {
        if (!$this->piecesAreInPositiveOrNegativeRange($value, 53)) {
            throw new InvalidArgumentException('Invalid value for BYWEEKNO');
        }

        $this->byWeekNo = $value;

        return $this;
    }

    /**
     * The BYYEARDAY rule part specifies a COMMA-separated list of days of the year.
     * Valid value is an array with values of 1 to 366 or -366 to -1.
     *
     * @param array $value
     *
     * @return $this
     */
    public function setByYearDay($value)
    {
        if (!$this->piecesAreInPositiveOrNegativeRange($value, 366)) {
            throw new InvalidArgumentException('Invalid value for BYYEARDAY');
        }

        $this->byYearDay = $value;

        return $this;
    }

    /**
     * The BYMONTHDAY rule part specifies a COMMA-separated list of days of the month.
     * Valid value is an array with values of 1 to 31 or -31 to -1.
     *
     * @param array $value
     *
     * @return $this
     */
    public function setByMonthDay($value)
    {
        if (!$this->piecesAreInPositiveOrNegativeRange($value, 31)) {
            throw new InvalidArgumentException('Invalid value for BYMONTHDAY');
        }

        $this->byMonthDay = $value;

        return $this;
    }


    /**
     * The BYDAY rule part specifies a COMMA-separated list of days of the week;.
     *
     * SU indicates Sunday; MO indicates Monday; TU indicates Tuesday;
     * WE indicates Wednesday; TH indicates Thursday; FR indicates Friday; and SA indicates Saturday.
     *
     * Each BYDAY value can also be preceded by a positive (+n) or negative (-n) integer.
     * If present, this indicates the nth occurrence of a specific day within the MONTHLY or YEARLY "RRULE".
     *
     * Valid value is an array with values of MO-SU
     *
     * @param array $value
     *
     * @return $this
     */
    public function setByDay($value)
    {
        //todo: refactor weekday array handling
        $weekdays = array(self::WEEKDAY_MONDAY, self::WEEKDAY_TUESDAY, self::WEEKDAY_WEDNESDAY, self::WEEKDAY_THURSDAY, self::WEEKDAY_FRIDAY, self::WEEKDAY_SATURDAY, self::WEEKDAY_SUNDAY);
        $weekdaysNeg = array();
        foreach ($weekdays as $weekday) {
            $weekdaysNeg[] = '.-' . $weekday;
        }
        if (!empty(array_diff($value, array_merge($weekdays, $weekdaysNeg)))) {
            throw new InvalidArgumentException('Invalid value for BYDAY');
        }
        $this->byDay = $value;

        return $this;
    }

    /**
     * The BYHOUR rule part specifies a COMMA-separated list of hours of the day.
     * Valid value is an array with values of 0 to 23.
     *
     * @param array $value
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setByHour($value)
    {
        if (!$this->piecesAreInRange($value, 59)) {
            throw new InvalidArgumentException('Invalid value for BYHOUR');
        }

        $this->byHour = $value;

        return $this;
    }

    /**
     * The BYMINUTE rule part specifies a COMMA-separated list of minutes within an hour.
     * Valid value is an array with values of 0 to 59.
     *
     * @param array $value
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setByMinute($value)
    {
        if (!$this->piecesAreInRange($value, 59)) {
            throw new InvalidArgumentException('Invalid value for BYMINUTE');
        }

        $this->byMinute = $value;

        return $this;
    }

    /**
     * The BYSECOND rule part specifies a COMMA-separated list of seconds within a minute.
     * Valid value is an array with values of 0 to 59.
     *
     * @param array $value
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setBySecond($value)
    {
        if (!$this->piecesAreInRange($value, 59)) {
            throw new InvalidArgumentException('Invalid value for BYSECOND');
        }

        $this->bySecond = $value;

        return $this;
    }

    /**
     * Check if pieces of an array are in a given range.
     *
     * @param int[] $value
     * @param int $max
     * @param int $min
     *
     * @return bool
     */
    private function piecesAreInRange($value, $max, $min = 0)
    {
        return empty(array_diff($value, $this->getRange($min, $max)));
    }

    /**
     * Check if pieces of an array are in a given range, as positives or negatives only.
     *
     * @param int[] $value
     * @param int $max
     * @param int $min
     *
     * @return bool
     */
    private function piecesAreInPositiveOrNegativeRange($value, $max, $min = 1)
    {
        $countDiffPositive = count(array_diff($value, $this->getRange($min, $max)));
        $countDiffNegative = count(array_diff($value, $this->getRange(-$min, -$max)));

        //return true if all pieces are in the positive range OR all pieces are in the negative range
        $isInPositiveRange = (0 == $countDiffPositive && count($value) == $countDiffNegative);
        $isInNegativeRange = (count($value) == $countDiffPositive && 0 == $countDiffNegative);

        return $isInPositiveRange || $isInNegativeRange;
    }

    /**
     * Get an array of integers in a given range of integer values.
     *
     * @param int $max
     * @param int $min
     *
     * @return array
     */
    private function getRange($min, $max)
    {
        $range = array();
        for ($i = $min; $i <= $max; $i++) {
            $range[] = $i;
        }

        return $range;
    }

}
