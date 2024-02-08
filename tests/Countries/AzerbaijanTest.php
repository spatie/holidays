<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate azerbaijani holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'az')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate azerbaijani holidays in english', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'az', locale: 'en')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
