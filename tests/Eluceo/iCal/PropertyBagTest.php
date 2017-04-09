<?php

namespace Eluceo\iCal;

use PHPUnit\Framework\TestCase;

class PropertyBagTest extends TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Property with name 'propName' already exists
     */
    public function testPropertyAlreadyExistsOnAddingProperty()
    {
        $propertyBag = new PropertyBag();
        $propertyBag->add(new Property('propName', ''));
        $propertyBag->add(new Property('propName', ''));
    }
}
