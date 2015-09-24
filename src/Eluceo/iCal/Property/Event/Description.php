<?php

namespace Eluceo\iCal\Property\Event;

use Eluceo\iCal\Property\ValueInterface;
use Eluceo\iCal\Util\PropertyValueUtil;

/**
 * Class Description
 * Alows new line charectars to be in the description
 *
 * @package Eluceo\iCal\Property
 */
class Description implements ValueInterface
{
    /**
     * The value.
     *
     * @var string
     */
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Return the value of the Property as an escaped string.
     *
     * Escape values as per RFC 2445. See http://www.kanzaki.com/docs/ical/text.html
     *
     * @return string
     */
    public function getEscapedValue()
    {
        return PropertyValueUtil::escapeValueAllowNewLine((string) $this->value);
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
