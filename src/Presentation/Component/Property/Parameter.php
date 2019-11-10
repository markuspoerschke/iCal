<?php

namespace Eluceo\iCal\Presentation\Component\Property;

final class Parameter
{
    private string $name;
    private Value $value;

    private function __construct(string $name, Value $value)
    {
        $this->name = strtoupper($name);
        $this->value = $value;
    }

    public static function create(string $name, Value $value): self
    {
        return new static($name, $value);
    }

    public function __toString(): string
    {
        return $this->name . '=' . $this->value;
    }
}
