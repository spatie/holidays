<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\Holidays;
use Spatie\Holidays\HolidayType;

it('can calculate korean holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'kr')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('celebrates Christmas on December 25 instead of December 15', function (int $year) {
    $holidays = Holidays::for(country: 'kr', year: $year);

    expect(findDate($holidays->get(), '크리스마스')?->format('Y-m-d'))->toBe("{$year}-12-25")
        ->and($holidays->getName("{$year}-12-25"))->toBe('크리스마스')
        ->and($holidays->isHoliday("{$year}-12-15"))->toBeFalse();
})->with([2023, 2024, 2026]);

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

it('makes Labour Day and Constitution Day public holidays from 2026', function () {
    expect(Holidays::for(country: 'kr', year: 2026)->getName('2026-05-01'))->toBe('노동절')
        ->and(Holidays::for(country: 'kr', year: 2026)->getName('2026-07-17'))->toBe('제헌절')
        ->and(Holidays::for(country: 'kr', year: 2025)->isHoliday('2025-05-01'))->toBeFalse()
        ->and(Holidays::for(country: 'kr', year: 2025)->isHoliday('2025-07-17'))->toBeFalse();
});

it('adds a substitute holiday after a holiday that falls on a day off', function (string $date) {
    $holidays = Holidays::for(country: 'kr', year: (int) substr($date, 0, 4))->get();

    $substitute = array_values(array_filter(
        $holidays,
        fn (Holiday $holiday): bool => $holiday->date->toDateString() === $date,
    ));

    expect($substitute)->toHaveCount(1)
        ->and($substitute[0]->name)->toBe('대체공휴일')
        ->and($substitute[0]->type)->toBe(HolidayType::Observed);
})->with([
    'Chuseok on a Sunday (2014)' => '2014-09-10',
    'Chuseok on National Foundation Day (2017)' => '2017-10-06',
    "Children's Day on a Sunday (2019)" => '2019-05-06',
    'Liberation Day on a Sunday (2021)' => '2021-08-16',
    'Hangul Day on a Saturday (2021)' => '2021-10-11',
    'Lunar New Year on a Sunday (2023)' => '2023-01-24',
    'Lunar New Year on a Sunday (2024)' => '2024-02-12',
    "Children's Day on a Sunday (2024)" => '2024-05-06',
    'Independence Movement Day on a Saturday (2025)' => '2025-03-03',
    "Children's Day on Buddha's Birthday (2025)" => '2025-05-06',
    'Chuseok on a Sunday (2025)' => '2025-10-08',
    'Independence Movement Day on a Sunday (2026)' => '2026-03-02',
    "Buddha's Birthday on a Sunday (2026)" => '2026-05-25',
    'Liberation Day on a Saturday (2026)' => '2026-08-17',
    'Labour Day on a Saturday (2027)' => '2027-05-03',
    'Constitution Day on a Saturday (2027)' => '2027-07-19',
    'Christmas on a Saturday (2027)' => '2027-12-27',
]);

it('adds no substitute holiday for a holiday the rule did not cover yet', function (string $date) {
    expect(Holidays::for(country: 'kr', year: (int) substr($date, 0, 4))->isHoliday($date))->toBeFalse();
})->with([
    'Lunar New Year on a Sunday before 2014 (2013)' => '2013-02-12',
    'Independence Movement Day on a Sunday before 2022 (2020)' => '2020-03-02',
    'Christmas on a Sunday before 2023 (2022)' => '2022-12-26',
    'Memorial Day on a Sunday (2021)' => '2021-06-07',
    'Chuseok on a Saturday only (2026)' => '2026-09-28',
]);
