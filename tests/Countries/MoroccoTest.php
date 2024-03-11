<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate morocco holidays 2024', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'ma')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate morocco holidays 2023', function () {
    CarbonImmutable::setTestNowAndTimezone('2023-01-01');

    $holidays = Holidays::for(country: 'ma')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate morocco holidays 2025', function () {
    CarbonImmutable::setTestNowAndTimezone('2025-01-01');

    $holidays = Holidays::for(country: 'ma')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate morocco holidays 2026', function () {
    CarbonImmutable::setTestNowAndTimezone('2026-01-01');

    $holidays = Holidays::for(country: 'ma')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
