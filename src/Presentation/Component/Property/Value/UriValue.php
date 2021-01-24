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

use Eluceo\iCal\Domain\ValueObject\Uri;
use Eluceo\iCal\Presentation\Component\Property\Value;

class UriValue extends Value
{
    private string $uri;

    public function __construct(Uri $url)
    {
        $this->uri = $url->getUri();
    }

    public function __toString(): string
    {
        return $this->uri;
    }
}
