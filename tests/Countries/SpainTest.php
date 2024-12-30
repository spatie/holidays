<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Spain;
use Spatie\Holidays\Holidays;

// 2025
it('can calculate spanish holidays 2025', function () {
    CarbonImmutable::setTestNow('2025-01-01');

    $holidays = Holidays::for(country: 'es')->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

it('can calculate spanish regional holidays 2025', function () {
    CarbonImmutable::setTestNow('2025-01-01');

    $holidays = Holidays::for(Spain::make('es-ct'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

// 2024
it('can calculate spanish holidays 2024', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'es')->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

it('can calculate spanish regional holidays 2024', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(Spain::make('es-ar'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();
});

// 2023
it('can calculate spanish holidays 2023', function () {
    CarbonImmutable::setTestNow('2023-01-01');

    $holidays = Holidays::for(country: 'es')->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();
});

it(/**
 * @throws \JsonException
 */ 'can calculate spanish regional holidays 2023', function () {
    CarbonImmutable::setTestNow('2023-01-01');

    $holidays = Holidays::for(Spain::make('es-ar'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

// 2022
it('can calculate spanish holidays 2022', function () {
    CarbonImmutable::setTestNow('2022-01-01');

    $holidays = Holidays::for(country: 'es')->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

it('can calculate spanish regional holidays 2022', function () {
    CarbonImmutable::setTestNow('2022-01-01');

    $holidays = Holidays::for(Spain::make('es-ar'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();
});
