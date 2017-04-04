<?php

namespace Eluceo\iCal;

use PHPUnit\Framework\TestCase;

class PropertyBagTest extends TestCase
{
    /**
     * @todo Use Mocks instead of a real object!
     *
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
