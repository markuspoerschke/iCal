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

final class Location
{
    private string $location;
    private ?string $title;
    private ?GeographicPosition $geographicPosition = null;

    public function __construct(string $location, string $title = null)
    {
        $this->location = $location;
        $this->title = $title;
    }

    public function withGeographicPosition(GeographicPosition $geographicPosition): self
    {
        $new = clone $this;
        $new->geographicPosition = $geographicPosition;

        return $new;
    }

    public function hasGeographicalPosition(): bool
    {
        return $this->geographicPosition !== null;
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function getGeographicPosition(): GeographicPosition
    {
        return $this->geographicPosition;
    }

    public function getTitle(): string
    {
        return (string) $this->title;
    }

    public function __toString(): string
    {
        return $this->location;
    }
}
