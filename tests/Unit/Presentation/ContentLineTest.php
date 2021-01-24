<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Test\Unit\Presentation;

use Eluceo\iCal\Presentation\ContentLine;
use PHPUnit\Framework\TestCase;

class ContentLineTest extends TestCase
{
    public function testShortLinesAreNotFolded()
    {
        $lineAsString = 'BEGIN:EVENT';
        $contentLine = new ContentLine($lineAsString);

        self::assertSame($lineAsString . ContentLine::LINE_SEPARATOR, (string) $contentLine);
    }

    public function testLongLinesAreFolder()
    {
        $lineAsString = 'SOMEPROPERTY:somesuperduperlongvaluethatneedstoobefoldedbecauseitistoolongtobedisplayedinasingleline';
        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'SOMEPROPERTY:somesuperduperlongvaluethatneedstoobefoldedbecauseitistoolongt',
            ' obedisplayedinasingleline',
            '',
        ]);

        $contentLine = new ContentLine($lineAsString);
        self::assertSame($expected, (string) $contentLine);
    }
}
