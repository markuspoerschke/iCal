<?php

namespace Eluceo\iCal\Domain\ValueObject;

/**
 * @see https://tools.ietf.org/html/rfc5545#section-3.8.4.7
 */
final class UniqueIdentifier
{
    private string $uid;

    public static function fromString(string $uid): self
    {
        return new static($uid);
    }

    public static function create(): self
    {
        return static::fromString(uniqid());
    }

    private function __construct(string $uid)
    {
        $this->uid = $uid;
    }

    public function __toString()
    {
        return $this->uid;
    }
}
