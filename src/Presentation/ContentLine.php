<?php


namespace Eluceo\iCal\Presentation;

final class ContentLine
{
    private const LINE_LENGTH = 75;
    private string $line;

    private function __construct(string $line)
    {
        $this->line = $line;
    }

    public static function fromString(string $line): self
    {
        return new static($line);
    }

    public function __toString()
    {
        $string = $this->line;
        $lines = [];

        while (strlen($string) > static::LINE_LENGTH) {
            $lines[] = mb_strcut($string, 0, static::LINE_LENGTH, 'utf-8');
            $string = ' ' . mb_strcut($string, static::LINE_LENGTH, strlen($string), 'utf-8');
        }
        $lines[] = $string;

        return implode(Component::LINE_SEPARATOR, $lines);
    }
}
