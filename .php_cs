<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2019-06
 */

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'no_unused_imports' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_empty_statement' => true,
        'include' => true,
        'no_leading_namespace_whitespace' => true,
        'single_quote' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'length',
        ],
        'concat_space' => [
            'spacing' => 'one',
        ],
    ])
    ->setFinder(PhpCsFixer\Finder::create()->exclude('vendor')->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]));