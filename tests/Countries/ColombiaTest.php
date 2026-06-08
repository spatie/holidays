<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate colombian holidays', function (int $year, int $totalHolidays) {
    CarbonImmutable::setTestNow("{$year}-01-01");

    $holidays = Holidays::for(country: 'co')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(count($holidays))->toBe($totalHolidays);

    expect(formatDates($holidays))->toMatchSnapshot();
})->with([
    [2025, 18],
    [2026, 19],
]);
