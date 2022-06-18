<?php

namespace Eluceo\iCal;

use PHPUnit\Framework\TestCase;

class PropertyBagTest extends TestCase
{
    public function testPropertyAlreadyExistsOnAddingProperty()
    {
        $this->expectExceptionMessage("Property with name 'propName' already exists");
        $this->expectException(\Exception::class);

        $propertyBag = new PropertyBag();
        $propertyBag->add(new Property('propName', ''));
        $propertyBag->add(new Property('propName', ''));
    }

    public function testGet()
    {
        $propertyBag = new PropertyBag();
        $propertyBag->add(new Property('propName', 'propValue'));
        $this->assertInstanceOf(Property::class, $propertyBag->get('propName'));
        $this->assertSame('propName', $propertyBag->get('propName')->getName());
        $this->assertNull($propertyBag->get('invalidPropName'));
    }
}
