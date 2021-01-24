<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Component\Property\Value;

use Eluceo\iCal\Domain\ValueObject\BinaryContent;
use Eluceo\iCal\Presentation\Component\Property\Value;

class BinaryValue extends Value
{
    private string $content;

    public function __construct(BinaryContent $binaryContent)
    {
        $this->content = base64_encode($binaryContent->getContent());
    }

    public function __toString(): string
    {
        return $this->content;
    }
}
