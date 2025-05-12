<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate georgian holidays', function () {
    CarbonImmutable::setTestNow('2025-01-01');

    $holidays = Holidays::for(country: 'ge')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate georgian holidays in english', function () {
    CarbonImmutable::setTestNow('2025-01-01');

    $holidays = Holidays::for(country: 'ge', locale: 'en')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
