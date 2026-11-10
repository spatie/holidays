<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\Holidays;
use Spatie\Holidays\HolidayType;

it('can calculate taiwan holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'tw')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});

// Days off of the government office calendar published by the Directorate-General of Personnel Administration:
// https://www.dgpa.gov.tw/informationlist?uid=30 (open data: https://data.gov.tw/dataset/14718)
it('matches the days off of the government office calendar', function (int $year, array $expectedDates) {
    $holidays = Holidays::for(country: 'tw', year: $year)->get();

    $dates = array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $holidays);

    // Children's Day and Tomb Sweeping Day share a date in some years.
    expect(array_values(array_unique($dates)))->toBe($expectedDates);
})->with([
    [2020, [
        '2020-01-01', '2020-01-23', '2020-01-24', '2020-01-25', '2020-01-26', '2020-01-27',
        '2020-01-28', '2020-01-29', '2020-02-28', '2020-04-02', '2020-04-03', '2020-04-04',
        '2020-06-25', '2020-06-26', '2020-10-01', '2020-10-02', '2020-10-09', '2020-10-10',
    ]],
    [2021, [
        '2021-01-01', '2021-02-10', '2021-02-11', '2021-02-12', '2021-02-13', '2021-02-14',
        '2021-02-15', '2021-02-16', '2021-02-28', '2021-03-01', '2021-04-02', '2021-04-04',
        '2021-04-05', '2021-06-14', '2021-09-20', '2021-09-21', '2021-10-10', '2021-10-11',
        '2021-12-31',
    ]],
    [2022, [
        '2022-01-01', '2022-01-31', '2022-02-01', '2022-02-02', '2022-02-03', '2022-02-04',
        '2022-02-28', '2022-04-04', '2022-04-05', '2022-06-03', '2022-09-09', '2022-09-10',
        '2022-10-10',
    ]],
    [2023, [
        '2023-01-01', '2023-01-02', '2023-01-20', '2023-01-21', '2023-01-22', '2023-01-23',
        '2023-01-24', '2023-01-25', '2023-01-26', '2023-01-27', '2023-02-27', '2023-02-28',
        '2023-04-03', '2023-04-04', '2023-04-05', '2023-06-22', '2023-06-23', '2023-09-29',
        '2023-10-09', '2023-10-10',
    ]],
    [2024, [
        '2024-01-01', '2024-02-08', '2024-02-09', '2024-02-10', '2024-02-11', '2024-02-12',
        '2024-02-13', '2024-02-14', '2024-02-28', '2024-04-04', '2024-04-05', '2024-06-10',
        '2024-09-17', '2024-10-10',
    ]],
    [2025, [
        '2025-01-01', '2025-01-27', '2025-01-28', '2025-01-29', '2025-01-30', '2025-01-31',
        '2025-02-28', '2025-04-03', '2025-04-04', '2025-05-30', '2025-05-31', '2025-09-28',
        '2025-09-29', '2025-10-06', '2025-10-10', '2025-10-24', '2025-10-25', '2025-12-25',
    ]],
    [2026, [
        '2026-01-01', '2026-02-15', '2026-02-16', '2026-02-17', '2026-02-18', '2026-02-19',
        '2026-02-20', '2026-02-27', '2026-02-28', '2026-04-03', '2026-04-04', '2026-04-05',
        '2026-04-06', '2026-05-01', '2026-06-19', '2026-09-25', '2026-09-28', '2026-10-09',
        '2026-10-10', '2026-10-25', '2026-10-26', '2026-12-25',
    ]],
    [2027, [
        '2027-01-01', '2027-02-04', '2027-02-05', '2027-02-06', '2027-02-07', '2027-02-08',
        '2027-02-09', '2027-02-10', '2027-02-28', '2027-03-01', '2027-04-04', '2027-04-05',
        '2027-04-06', '2027-04-30', '2027-05-01', '2027-06-09', '2027-09-15', '2027-09-28',
        '2027-10-10', '2027-10-11', '2027-10-25', '2027-12-24', '2027-12-25', '2027-12-31',
    ]],

]);

it('lists the lunar new year holidays', function () {
    // Lunar New Year 2027 is on 6 February, a day before the date that ICU calculates.
    $holidays = Holidays::for(country: 'tw', year: 2027)->get();

    expect(findDate($holidays, '農曆除夕')?->format('Y-m-d'))->toBe('2027-02-05');
    expect(findDate($holidays, '農曆春節-正月初一')?->format('Y-m-d'))->toBe('2027-02-06');
    expect(findDate($holidays, '農曆春節-正月初三')?->format('Y-m-d'))->toBe('2027-02-08');

    // The day before Lunar New Year's Eve and the days added after the festival.
    $holidays = Holidays::for(country: 'tw', year: 2024)->get();

    expect(findDate($holidays, '小年夜')?->format('Y-m-d'))->toBe('2024-02-08');
    expect(findDate($holidays, '補假')?->format('Y-m-d'))->toBe('2024-02-13');
});

it('lists children\'s day and tomb sweeping day separately', function () {
    $holidays = Holidays::for(country: 'tw', year: 2022)->get();

    expect(findDate($holidays, '兒童節')?->format('Y-m-d'))->toBe('2022-04-04');
    expect(findDate($holidays, '民族掃墓節')?->format('Y-m-d'))->toBe('2022-04-05');

    $holidays = Holidays::for(country: 'tw', year: 2024)->get();

    expect(findDate($holidays, '兒童節')?->format('Y-m-d'))->toBe('2024-04-04');
    expect(findDate($holidays, '民族掃墓節')?->format('Y-m-d'))->toBe('2024-04-04');

    // Tomb Sweeping Day is called Qingming Festival from 2026.
    $holidays = Holidays::for(country: 'tw', year: 2026)->get();

    expect(findDate($holidays, '清明節')?->format('Y-m-d'))->toBe('2026-04-05');
});

it('lists the commemorative days that were added in 2025 and 2026', function () {
    $holidays = Holidays::for(country: 'tw', year: 2025)->get();

    expect(findDate($holidays, '孔子誕辰紀念日')?->format('Y-m-d'))->toBe('2025-09-28');
    expect(findDate($holidays, '臺灣光復暨金門古寧頭大捷紀念日')?->format('Y-m-d'))->toBe('2025-10-25');
    expect(findDate($holidays, '行憲紀念日')?->format('Y-m-d'))->toBe('2025-12-25');
    expect(findDate($holidays, '勞動節'))->toBeNull();

    $holidays = Holidays::for(country: 'tw', year: 2026)->get();

    expect(findDate($holidays, '勞動節')?->format('Y-m-d'))->toBe('2026-05-01');
    expect(findDate($holidays, '孔子誕辰紀念日/教師節')?->format('Y-m-d'))->toBe('2026-09-28');
});

it('returns the days that the government adds to a year as observed holidays', function () {
    $holidays = Holidays::for(country: 'tw', year: 2023)->get();

    $observed = array_values(array_filter(
        $holidays,
        fn (Holiday $holiday): bool => $holiday->type === HolidayType::Observed,
    ));

    expect(array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $observed))->toBe([
        '2023-01-02', '2023-01-25', '2023-01-26', '2023-01-27', '2023-02-27', '2023-04-03', '2023-06-23', '2023-10-09',
    ]);
    expect(array_values(array_unique(array_map(fn (Holiday $holiday): string => $holiday->name, $observed))))
        ->toBe(['補假', '調整放假']);
});

it('only calculates the fixed days and lunar festivals for years without a published calendar', function () {
    $holidays = Holidays::for(country: 'tw', year: 2030)->get();

    expect(array_map(fn (Holiday $holiday): string => $holiday->name, $holidays))->toBe([
        '元旦',
        '農曆春節-正月初一',
        '農曆春節-正月初二',
        '農曆春節-正月初三',
        '228和平紀念日',
        '兒童節',
        '端午節',
        '中秋節',
        '雙十國慶',
    ]);
});

it('has an english translation for every taiwan holiday', function () {
    $translations = json_decode((string) file_get_contents(__DIR__.'/../../lang/tw/en/holidays.json'), true);

    foreach ([...range(2015, 2035)] as $year) {
        foreach (Holidays::for(country: 'tw', year: $year)->get() as $holiday) {
            expect($translations)->toHaveKey($holiday->name);
        }
    }
});
