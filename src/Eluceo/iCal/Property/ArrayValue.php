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

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function setValues(array $values)
    {
        $this->values = $values;

        return $this;
    }

    public function getEscapedValue()
    {
        $escapedValues = array_map(function ($value) {
            $stringValue = new StringValue($value);
            return $stringValue->getEscapedValue();
        }, $this->values);

        return implode(',', $escapedValues);
    }
}
