<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

//https://neradni-dani.com/kalendar-2024.php
it('can calculate croatian holidays for 2024', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'hr')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->toHaveCount(14);

    expect(formatDates($holidays))->toMatchSnapshot();
});

//https://neradni-dani.com/kalendar-2025.php
it('can calculate croatian holidays for 2025', function () {
    CarbonImmutable::setTestNowAndTimezone('2025-01-01');

    $holidays = Holidays::for(country: 'hr')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->toHaveCount(14);

    expect(formatDates($holidays))->toMatchSnapshot();
});

//https://neradni-dani.com/kalendar-2026.php
it('can calculate croatian holidays for 2026', function () {
    CarbonImmutable::setTestNowAndTimezone('2026-01-01');

    $holidays = Holidays::for(country: 'hr')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->toHaveCount(14);

    expect(formatDates($holidays))->toMatchSnapshot();
});
