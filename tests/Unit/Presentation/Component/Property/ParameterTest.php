<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2020 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation\Component\Property;

use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testParameterToString()
    {
        $parameter = Parameter::create('TEST', TextValue::fromString('lorem ipsum'));
        self::assertSame('TEST=lorem ipsum', (string) $parameter);
    }
}
