<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

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
