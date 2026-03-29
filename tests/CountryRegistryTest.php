<?php

namespace Spatie\Holidays\Tests;

use Spatie\Holidays\Countries\Belgium;
use Spatie\Holidays\Countries\England;
use Spatie\Holidays\Countries\Germany;
use Spatie\Holidays\Countries\Netherlands;
use Spatie\Holidays\Countries\NorthernIreland;
use Spatie\Holidays\Countries\Scotland;
use Spatie\Holidays\Countries\UnitedStates;
use Spatie\Holidays\Countries\Wales;
use Spatie\Holidays\CountryRegistry;

it('can find a country by code', function (string $code, string $expectedClass) {
    $result = CountryRegistry::find($code);

    expect($result)->toBe($expectedClass);
})->with([
    ['be', Belgium::class],
    ['nl', Netherlands::class],
    ['de', Germany::class],
    ['us', UnitedStates::class],
    ['gb-eng', England::class],
    ['gb-sct', Scotland::class],
    ['gb-nir', NorthernIreland::class],
    ['gb-cym', Wales::class],
]);

it('find is case insensitive', function (string $code, string $expectedClass) {
    $result = CountryRegistry::find($code);

    expect($result)->toBe($expectedClass);
})->with([
    ['BE', Belgium::class],
    ['NL', Netherlands::class],
    ['De', Germany::class],
    ['US', UnitedStates::class],
    ['GB-ENG', England::class],
]);

it('returns null for unknown country code', function () {
    $result = CountryRegistry::find('xx');

    expect($result)->toBeNull();
});

it('returns all registered countries', function () {
    $all = CountryRegistry::all();

    expect($all)->toBeArray();
    expect($all)->not()->toBeEmpty();
    expect($all['be'])->toBe(Belgium::class);
    expect($all['nl'])->toBe(Netherlands::class);
    expect($all['de'])->toBe(Germany::class);
});
