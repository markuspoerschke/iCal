<?php

namespace Eluceo\iCal\Property\Event;

use Eluceo\iCal\Property;

/**
 * Class Organizer.
 */
class Organizer extends Property
{
    const PROPERTY_NAME = 'ORGANIZER';

    /**
     * @param string $value
     * @param array  $params
     */
    public function __construct($value, $params = array())
    {
        parent::__construct(self::PROPERTY_NAME, $value, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::PROPERTY_NAME;
    }
}
