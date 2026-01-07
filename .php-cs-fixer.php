<?php

$headerComment = <<<EOF
This file is part of the eluceo/iCal package.

(c) Markus Poerschke <markus@eluceo.de>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = PhpCsFixer\Finder::create()->in(__DIR__ . '/src');

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'ordered_imports' => true,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        'header_comment' => ['header' => $headerComment],
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
