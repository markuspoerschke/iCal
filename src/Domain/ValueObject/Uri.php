<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

use InvalidArgumentException;

final class Uri
{
    private string $uri;

    public function __construct(string $uri)
    {
        if (!filter_var($uri, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("$uri is no valid URI");
        }

        $this->uri = $uri;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
