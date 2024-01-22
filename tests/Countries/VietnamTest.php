<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Vietnam;
use Spatie\Holidays\Holidays;

it('can calculate vietnamese holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01', 'Asia/Ho_Chi_Minh');

    $holidays = Holidays::for(country: 'vn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate the Lunar New Year holiday', function ($year, $expectedHoliday) {
    CarbonImmutable::setTestNowAndTimezone("{$year}-01-01", 'Asia/Ho_Chi_Minh');

    $holidays = Holidays::for(country: 'vn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    $lunarNewYearHoliday = array_map(fn ($date) => $date['date'], formatDates($holidays));

    expect($lunarNewYearHoliday)->toContain(...$expectedHoliday);
})->with([
    ['year' => 2023, 'expected_holiday' => ['2023-01-21', '2023-01-22', '2023-01-23', '2023-01-24', '2023-01-25']],
    ['year' => 2021, 'expected_holiday' => ['2021-02-11', '2021-02-12', '2021-02-13', '2021-02-14', '2021-02-15']],
    ['year' => 2019, 'expected_holiday' => ['2019-02-04', '2019-02-05', '2019-02-06', '2019-02-07', '2019-02-08']],
]);

it('can calculate the holiday of independence', function ($year, $expectedHoliday) {
    CarbonImmutable::setTestNowAndTimezone("{$year}-01-01", 'Asia/Ho_Chi_Minh');

    $holidays = Holidays::for(country: 'vn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    $independenceHoliday = array_map(fn ($date) => $date['date'], formatDates($holidays));

    expect($independenceHoliday)->toContain(...$expectedHoliday);
})->with([
    ['year' => 2023, 'expected_holiday' => ['2023-09-01', '2023-09-02']],
    ['year' => 2022, 'expected_holiday' => ['2022-09-01', '2022-09-02']],
    ['year' => 2021, 'expected_holiday' => ['2021-09-02', '2021-09-03']],
]);
