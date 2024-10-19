<?php

namespace Spatie\Holidays\Tests\Countries;

use Spatie\Holidays\Holidays;

it('provides holiday at least according to Gregorian Calendar', function () {
    $holidays = Holidays::for(country: 'np')->get(year: 2024);

    expect($holidays)->toBeArray()->not->toBeEmpty();
});

it('provides holiday at least according to Bikram Sambat Calendar', function () {
    $holidays = Holidays::for(country: 'np')->get(year: 2025);

    expect($holidays)->toBeArray()->not->toBeEmpty();
});

it('provides holiday for Nepal in year 2024', function () {
    $holidays = Holidays::for(country: 'np')->get(year: 2024);

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('checks for holidays in Nepal for 2025', function () {
    $isHoliday = Holidays::for('np')->isHoliday('2025-03-13');

    expect($isHoliday)->toBeTrue();
});
