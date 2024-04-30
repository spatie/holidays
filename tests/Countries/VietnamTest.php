<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate vietnamese holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'vn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate the Lunar New Year holiday', function ($year, $expectedHoliday) {
    CarbonImmutable::setTestNow("{$year}-01-01");

    $holidays = Holidays::for(country: 'vn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    $lunarNewYearHoliday = array_map(fn ($date) => $date['date'], formatDates($holidays));

    expect($lunarNewYearHoliday)->toContain(...$expectedHoliday);
})->with([
    ['year' => 2023, 'expected_holiday' => ['2023-01-20', '2023-01-21', '2023-01-22', '2023-01-23', '2023-01-24', '2023-01-25', '2023-01-26']],
    ['year' => 2022, 'expected_holiday' => ['2022-01-30', '2022-01-31', '2022-02-01', '2022-02-02', '2022-02-03', '2022-02-04', '2022-02-05']],
    ['year' => 2021, 'expected_holiday' => ['2021-02-10', '2021-02-11', '2021-02-12', '2021-02-13', '2021-02-14', '2021-02-15', '2021-02-16']],
    ['year' => 2020, 'expected_holiday' => ['2020-01-23', '2020-01-24', '2020-01-25', '2020-01-26', '2020-01-27', '2020-01-28', '2020-01-29']],
    ['year' => 2019, 'expected_holiday' => ['2019-02-03', '2019-02-04', '2019-02-05', '2019-02-06', '2019-02-07', '2019-02-08', '2019-02-08']],
]);

it('can calculate the holiday of independence', function ($year, $expectedHoliday) {
    CarbonImmutable::setTestNow("{$year}-01-01");

    $holidays = Holidays::for(country: 'vn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    $dates = array_map(fn ($date) => $date['date'], formatDates($holidays));

    expect($dates)->toContain(...$expectedHoliday);
})->with([
    ['year' => 2023, 'expected_holiday' => ['2023-09-01', '2023-09-02']],
    ['year' => 2022, 'expected_holiday' => ['2022-09-01', '2022-09-02']],
    ['year' => 2021, 'expected_holiday' => ['2021-09-02', '2021-09-03']],
]);
