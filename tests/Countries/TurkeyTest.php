<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate turkey holidays', function ($year) {
    CarbonImmutable::setTestNow($year.'-01-01');

    $holidays = Holidays::for(country: 'tr')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
})->with([1970, 1973, 1974, 1975, 1999, 2000, 2001, 2005, 2006, 2007, 2008, 2009, 2016, 2017, 2021, 2022, 2023, 2024, 2025, 2032, 2033, 2034, 2037]);
