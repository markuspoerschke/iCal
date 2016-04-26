<?php

$finder = Symfony\CS\Finder\DefaultFinder::create();
$finder->in(__DIR__ . '/src');

return Symfony\CS\Config\Config::create()
    ->fixers(array(
        'concat_with_spaces',
        'align_equals',
        'align_double_arrow',
        'unused_use',
        'long_array_syntax',
    ))
    ->finder($finder)
;
