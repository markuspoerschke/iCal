<?php

namespace Eluceo\iCal\Presentation\Component;

use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value;

class Property
{
    private string $name;

    /**
     * @var array<int, Parameter>
     */
    private array $parameters = [];

    private Value $value;

    private function __construct(string $name, Value $value, array $parameters)
    {
        $this->name = strtoupper($name);
        $this->value = $value;
        array_walk($parameters, [$this, 'addParameter']);
    }

    public static function create(string $name, Value $value, array $parameters = []): self
    {
        return new static($name, $value, $parameters);
    }

    public function __toString(): string
    {
        $string = $this->name;

        if (count($this->parameters) > 0) {
            $string .= ':' . implode(';', array_map('strval', $this->parameters));
        }

        return $string . ':' . $this->value;
    }

    private function addParameter(Parameter $parameter): void
    {
        $this->parameters[] = $parameter;
    }
}
