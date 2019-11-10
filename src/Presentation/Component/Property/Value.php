<?php

namespace Eluceo\iCal\Presentation\Component\Property;

abstract class Value
{
    abstract public function __toString(): string;
}
