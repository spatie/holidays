<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate jamaican holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'jm')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate observed holidays based on year', function () {

    // Check for Observed New Year's Day
    $holidays = Holidays::for(country: 'jm', year: 2023)->get();
    expect(array_search('New Year\'s Day Observed', array_column($holidays, 'name')))->toBeInt();

    // Check for Observed Labour Day
    $holidays = Holidays::for(country: 'jm', year: 2020)->get();
    expect(array_search('Labour Day Observed', array_column($holidays, 'name')))->toBeInt();

    // Check that there is no Observerd New Year's Day
    $holidays = Holidays::for(country: 'jm', year: 2024)->get();
    expect(array_search('Labour Day Observed', array_column($holidays, 'name')))->toBeFalse();
});
