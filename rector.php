<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\Config\RectorConfig;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths(['src'])
    ->withPhpSets(php81: true)
    ->withPreparedSets(deadCode: true, codingStyle: true, typeDeclarations: true)
    ->withSkip([
        NullToStrictStringFuncCallArgRector::class,
        ClosureToArrowFunctionRector::class,
        ReturnNeverTypeRector::class,
        AddClosureVoidReturnTypeWhereNoReturnRector::class,
        StaticClosureRector::class,
        StaticArrowFunctionRector::class,
        SplitDoubleAssignRector::class,
        NullableCompareToNullRector::class,
        EncapsedStringsToSprintfRector::class,
        CatchExceptionNameMatchingTypeRector::class,
        PostIncDecToPreIncDecRector::class,
    ]);
