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

/**
 * @see https://tools.ietf.org/html/rfc5545#section-3.8.4.7
 */
final class UniqueIdentifier
{
    private string $uid;

    public function __construct(string $uid)
    {
        $this->uid = $uid;
    }

    public static function createRandom(): self
    {
        if (function_exists('random_bytes')) {
            return new self(bin2hex(random_bytes(16)));
        }

        return new self(uniqid());
    }

    public function __toString(): string
    {
        return $this->uid;
    }
}
