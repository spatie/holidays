<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;
use Spatie\Holidays\Countries\NorthMacedonia;

it('can calculate macedonian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'mk')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can retreive valid holiday for ethnical groups', function () {
    //$holidays = Holidays::for(country: 'mk?type=orhodox')->get();
    $holidays = Holidays::for(NorthMacedonia::make(['type' => 'orthodox']))->get();

    expect($holidays)
        ->toBeArray();

    // TODO: add more tests for ethnical groups
});