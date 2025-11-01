<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = new Finder()
    ->in([
        'config',
        'src',
    ])
    ->append([__FILE__])
;

return new Config()
    ->setFinder($finder)
    ->setRules([
        '@Symfony' => true,
    ])
;
