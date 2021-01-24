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

class Attachment
{
    private ?BinaryContent $binaryContent = null;
    private ?Uri $uri = null;
    private ?string $mimeType;

    /**
     * @param BinaryContent|Uri $content
     */
    public function __construct(object $content, ?string $mimeType = null)
    {
        $this->mimeType = $mimeType;

        if ($content instanceof BinaryContent) {
            $this->binaryContent = $content;
        }

        if ($content instanceof Uri) {
            $this->uri = $content;
        }

        if ($this->uri === null && $this->binaryContent === null) {
            throw new InvalidArgumentException(sprintf('$content is invalid. An instance of %s or %s was expected, but an instance of %s was given.', BinaryContent::class, Uri::class, get_class($content)));
        }
    }

    public function hasUri(): bool
    {
        return $this->uri !== null;
    }

    public function getUri(): Uri
    {
        assert($this->uri !== null);

        return $this->uri;
    }

    public function hasBinaryContent(): bool
    {
        return $this->binaryContent !== null;
    }

    public function getBinaryContent(): BinaryContent
    {
        assert($this->binaryContent !== null);

        return $this->binaryContent;
    }

    public function hasMimeType(): bool
    {
        return $this->mimeType !== null;
    }

    public function getMimeType(): string
    {
        assert($this->mimeType !== null);

        return $this->mimeType;
    }
}
