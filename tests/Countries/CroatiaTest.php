<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate croatian holidays', function (int $year) {
    CarbonImmutable::setTestNow("{$year}-01-01");

    $holidays = Holidays::for(country: 'hr', year: $year)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
})->with([2024, 2025, 2026, 2027]);
