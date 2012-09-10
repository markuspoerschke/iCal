<?php

namespace Eluceo\iCal;

class PropertyBag implements \IteratorAggregate
{
    protected $elements = array();

    public function set($key, $value)
    {
        $this->elements[strtoupper($key)] = $value;
    }

    public function get($key)
    {
        return $this->elements[strtoupper($key)];
    }

    public function add(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function getIterator()
    {
        return $this->elements;
    }
}