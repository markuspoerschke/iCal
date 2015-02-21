<?php

namespace Eluceo\iCal\Property;

class ArrayValue implements ValueInterface
{
    /**
     * The value.
     *
     * @var array
     */
    protected $values;

    public function __construct($values)
    {
        $this->values = $values;
    }

    public function setValues($values)
    {
        $this->values = $values;

        return $this;
    }

    public function getEscapedValue()
    {
        $escapedValues = array_map(function ($value) {
            return (new StringValue($value))->getEscapedValue();
        }, $this->values);

        return implode(',', $escapedValues);
    }
}
