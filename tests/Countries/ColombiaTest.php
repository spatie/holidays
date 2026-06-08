<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate colombian holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'co')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate colombian holidays from 2026', function () {
    CarbonImmutable::setTestNow('2026-01-01');

    $holidays = Holidays::for(country: 'co')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('takes into account a new holiday only from year 2026', function () {
    CarbonImmutable::setTestNow('2026-01-01');

    $holidays2025 = Holidays::for(country: 'co', year: 2025)->get();
    $holidays2026 = Holidays::for(country: 'co')->get();

    expect(count($holidays2025))->toBe(18);
    expect(count($holidays2026))->toBe(19);
});
