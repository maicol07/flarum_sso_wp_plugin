<?php

use Rector\Config\RectorConfig;
use Rector\Php54\Rector\Array_\LongArrayToShortArrayRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;

// PHP sets follow the composer.json PHP floor, so the output stays installable there.
return RectorConfig::configure()
    ->withPaths(['sso-flarum.php', 'uninstall.php', 'includes', 'admin', 'public'])
    ->withPhpSets()
    ->withSkip([
        // WPCS requires long array syntax.
        LongArrayToShortArrayRector::class,
        // Promotion renames public constructor parameters, breaking named arguments.
        ClassPropertyAssignToConstructorPromotionRector::class,
    ]);
