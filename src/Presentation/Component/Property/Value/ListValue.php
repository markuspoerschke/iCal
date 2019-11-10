<?php

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use Eluceo\iCal\Presentation\Component\Property\Value;

class ListValue extends Value
{
    private array $values = [];

    private function __construct(array $values)
    {
        array_walk($values, [$this, 'addValue']);
    }

    public static function fromStringValues(array $values): self
    {
        return new static($values);
    }

    public function __toString(): string
    {
        return implode(',', array_map('strval', $this->values));
    }

    private function addValue(Value $value): void
    {
        $this->values[] = $value;
    }
}
