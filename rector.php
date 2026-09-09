<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

return RectorConfig::configure()
    // Explicitly target source, route, view, and test directories
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/bootstrap',
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    // Skip framework caches and overly strict return type rules
    ->withSkip([
        __DIR__.'/vendor',
        __DIR__.'/storage',
        __DIR__.'/node_modules',
        __DIR__.'/bootstrap/cache',
        DeclareStrictTypesRector::class => [
            __DIR__.'/resources/views',
        ],
    ])
    // Auto-detect target PHP version directly from composer.json
    ->withPhpSets()
    // Convert fully-qualified class names into imported 'use' statements
    ->withImportNames()
    // Auto-detect and set rules for the active Laravel version
    ->withComposerBased(laravel: true)
    // Enforce strict typing across all scanned PHP files for improved type security
    ->withRules([
        DeclareStrictTypesRector::class,
    ]);
