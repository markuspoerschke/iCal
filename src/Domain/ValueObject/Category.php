<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Domain\ValueObject;

final class Category
{
    private string $category;

    public function __construct(string $category)
    {
        $this->category = $category;
    }

    public function __toString(): string
    {
        return $this->category;
    }
}
