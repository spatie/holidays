<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate uzbekistan holidays', function ($year) {
    CarbonImmutable::setTestNow($year.'-01-01');

    $holidays = Holidays::for(country: 'uz')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
})->with([2000, 2006, 2022, 2023]);
