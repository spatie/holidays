<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate singapore 2024 holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'sg')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});

it('can calculate singapore 2023 holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2023-01-01');

    $holidays = Holidays::for(country: 'sg')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});

it('can calculate singapore 2022 holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2022-01-01');

    $holidays = Holidays::for(country: 'sg')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});
