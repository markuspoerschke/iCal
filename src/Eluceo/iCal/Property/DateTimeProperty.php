<?php

namespace Eluceo\iCal\Property;

use Eluceo\iCal\Property;
use Eluceo\iCal\Util\DateUtil;

class DateTimeProperty extends Property
{
    /**
     * @param string    $name
     * @param \DateTime $dateTime
     * @param bool      $noTime
     * @param bool      $useTimezone
     * @param bool      $useUtc
     */
    public function __construct(
        $name,
        \DateTime $dateTime = null,
        $noTime = false,
        $useTimezone = false,
        $useUtc = false
    ) {
        $dateString = DateUtil::getDateString($dateTime, $noTime, $useTimezone, $useUtc);
        $params = DateUtil::getDefaultParams($dateTime, $noTime, $useTimezone);

        parent::__construct($name, $dateString, $params);
    }
}
