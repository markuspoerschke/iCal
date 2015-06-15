<?php
namespace Eluceo\iCal\Property\Event;

use Eluceo\iCal\Property;

class Organizer extends Property
{
    const PROPERTY_NAME = 'ORGANIZER';

    /**
     * @param null $value
     * @param array $params
     * @throws \Exception
     */
    public function __construct($value = null, $params = array())
    {
        $value = $value ? sprintf('CN=%s', $value) : '';

        return parent::__construct($this->getName(), $value, $params);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return self::PROPERTY_NAME;
    }
}
