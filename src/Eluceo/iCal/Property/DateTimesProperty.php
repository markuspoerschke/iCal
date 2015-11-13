<?php

namespace Eluceo\iCal\Property;

use Eluceo\iCal\Property;
use Eluceo\iCal\Util\DateUtil;

class DateTimesProperty extends Property
{
    /**
     * @param string      $name
     * @param \DateTime[] $dateTimes
     * @param bool        $noTime
     * @param bool        $useTimezone
     * @param bool        $useUtc
     */
    public function __construct(
        $name,
        $dateTimes = array(),
        $noTime = false,
        $useTimezone = false,
        $useUtc = false
    ) {
        $dates = array();
        foreach ($dateTimes as $dateTime) {
            $dates[] = DateUtil::getDateString($dateTime, $noTime, $useTimezone, $useUtc);
        }
        $params = DateUtil::getDefaultParams($dateTime, $noTime, $useTimezone);

        parent::__construct($name, $dates, $params);
    }
}
