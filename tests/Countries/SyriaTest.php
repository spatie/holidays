<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate syrian holidays', function ($year) {
    CarbonImmutable::setTestNow($year.'-01-01');

    $holidays = Holidays::for(country: 'sy')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
})->with([2022, 2023, 2024]);

it('can translate syrian holidays into arabic', function () {
    
    $holidays = Holidays::for(country: 'sy', year: 2024, locale: 'ar')->get();
    
    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
