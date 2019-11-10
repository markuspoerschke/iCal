<?php

namespace Eluceo\iCal\Test\Unit\Presentation;

use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\ContentLine;
use PHPUnit\Framework\TestCase;

class ContentLineTest extends TestCase
{
    public function testShortLinesAreNotFolded()
    {
        $lineAsString = 'BEGIN:EVENT';
        $contentLine = ContentLine::fromString($lineAsString);

        self::assertSame($lineAsString, (string)$contentLine);
    }

    public function testLongLinesAreFolder()
    {
        $lineAsString = 'SOMEPROPERTY:somesuperduperlongvaluethatneedstoobefoldedbecauseitistoolongtobedisplayedinasingleline';
        $expected = implode(Component::LINE_SEPARATOR, [
            'SOMEPROPERTY:somesuperduperlongvaluethatneedstoobefoldedbecauseitistoolongt',
            ' obedisplayedinasingleline',
        ]);

        $contentLine = ContentLine::fromString($lineAsString);
        self::assertSame($expected, (string)$contentLine);
    }
}
