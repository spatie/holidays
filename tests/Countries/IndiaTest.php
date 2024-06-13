<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate India holidays for 2024', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'in')->get();
    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('does not return a holiday falsely', function () {
    $dateInstance = CarbonImmutable::createFromDate('2024-01-03');
    $holiday = Holidays::for(country: 'in');

    $isHoliday = $holiday->isHoliday($dateInstance);
    expect($isHoliday)->toBeFalse();

    $holidayName = $holiday->getName($dateInstance);
    expect($holidayName)->toBeNull();
});

it('can calculate India holidays', function ($year) {
    CarbonImmutable::setTestNow($year.'-01-01');
    $holidays = Holidays::for('in')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
})->with([1970, 1977, 2000, 2018, 2037]);
