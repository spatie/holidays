<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate korean holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'kr')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate the Lunar New Year holiday', function ($year, $expectedHoliday) {
    CarbonImmutable::setTestNow("{$year}-01-01");

    $holidays = Holidays::for(country: 'kr')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    $lunarNewYearHoliday = array_map(fn ($date) => $date['date'], formatDates($holidays));

    expect($lunarNewYearHoliday)->toContain(...$expectedHoliday);
})->with([
    [
        2024, [
            '2024-02-09', '2024-02-10', '2024-02-11',
        ],
    ],
    [
        2023, [
            '2023-01-21', '2023-01-22', '2023-01-23',
        ],
    ],
    [
        2022, [
            '2022-01-31', '2022-02-01', '2022-02-02',
        ],
    ],
    [
        2021, [
            '2021-02-11', '2021-02-12', '2021-02-13',
        ],
    ],
    [
        2020, [
            '2020-01-24', '2020-01-25', '2020-01-26',
        ],
    ],
]);

it('can calculate the holiday of Lunar Buddha\'s Birthday', function ($year, $expectedHoliday) {
    CarbonImmutable::setTestNow("{$year}-01-01");

    $holidays = Holidays::for(country: 'kr')->get();
    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    $dates = array_map(fn ($date) => $date['date'], formatDates($holidays));

    expect($dates)->toContain(...$expectedHoliday);
})->with([
    [2024, ['2024-05-15']],
    [2023, ['2023-05-26']],
    [2022, ['2022-05-08']],
]);

it('can calculate the Lunar Chuseok holiday', function ($year, $expectedHoliday) {
    CarbonImmutable::setTestNow("{$year}-01-01");

    $holidays = Holidays::for(country: 'kr')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    $lunarNewYearHoliday = array_map(fn ($date) => $date['date'], formatDates($holidays));

    expect($lunarNewYearHoliday)->toContain(...$expectedHoliday);
})->with([
    [
        2024, [
            '2024-09-16', '2024-09-17', '2024-09-18',
        ],
    ],
    [
        2023, [
            '2023-09-28', '2023-09-29', '2023-09-30',
        ],
    ],
    [
        2022, [
            '2022-09-09', '2022-09-10', '2022-09-11',
        ],
    ],
    [
        2021, [
            '2021-09-20', '2021-09-21', '2021-09-22',
        ],
    ],
    [
        2020, [
            '2020-09-30', '2020-10-01', '2020-10-02',
        ],
    ],
]);
