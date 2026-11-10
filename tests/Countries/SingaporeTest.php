<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\Holidays;
use Spatie\Holidays\HolidayType;

it('can calculate singapore holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'sg')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

// Dates as published by the Ministry of Manpower: https://www.mom.gov.sg/employment-practices/public-holidays
// Public holidays declared for an election (Polling Day) are not part of the list.
it('matches the public holidays published by the ministry of manpower', function (int $year, array $expectedDates) {
    $holidays = Holidays::for(country: 'sg', year: $year)->get();

    $dates = array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $holidays);

    expect($dates)->toBe($expectedDates);
})->with([
    [2020, [
        '2020-01-01', '2020-01-25', '2020-01-26', '2020-01-27', '2020-04-10', '2020-05-01', '2020-05-07',
        '2020-05-24', '2020-05-25', '2020-07-31', '2020-08-09', '2020-08-10', '2020-11-14', '2020-12-25',
    ]],
    [2021, [
        '2021-01-01', '2021-02-12', '2021-02-13', '2021-04-02', '2021-05-01', '2021-05-13', '2021-05-26',
        '2021-07-20', '2021-08-09', '2021-11-04', '2021-12-25',
    ]],
    [2022, [
        '2022-01-01', '2022-02-01', '2022-02-02', '2022-04-15', '2022-05-01', '2022-05-02', '2022-05-03',
        '2022-05-15', '2022-05-16', '2022-07-10', '2022-07-11', '2022-08-09', '2022-10-24', '2022-12-25',
        '2022-12-26',
    ]],
    [2023, [
        '2023-01-01', '2023-01-02', '2023-01-22', '2023-01-23', '2023-01-24', '2023-04-07', '2023-04-22',
        '2023-05-01', '2023-06-02', '2023-06-29', '2023-08-09', '2023-11-12', '2023-11-13', '2023-12-25',
    ]],
    [2024, [
        '2024-01-01', '2024-02-10', '2024-02-11', '2024-02-12', '2024-03-29', '2024-04-10', '2024-05-01',
        '2024-05-22', '2024-06-17', '2024-08-09', '2024-10-31', '2024-12-25',
    ]],
    [2025, [
        '2025-01-01', '2025-01-29', '2025-01-30', '2025-03-31', '2025-04-18', '2025-05-01', '2025-05-12',
        '2025-06-07', '2025-08-09', '2025-10-20', '2025-12-25',
    ]],
    [2026, [
        '2026-01-01', '2026-02-17', '2026-02-18', '2026-03-21', '2026-04-03', '2026-05-01', '2026-05-27',
        '2026-05-31', '2026-06-01', '2026-08-09', '2026-08-10', '2026-11-08', '2026-11-09', '2026-12-25',
    ]],
    [2027, [
        '2027-01-01', '2027-02-06', '2027-02-07', '2027-02-08', '2027-03-10', '2027-03-26', '2027-05-01',
        '2027-05-17', '2027-05-20', '2027-08-09', '2027-10-28', '2027-12-25',
    ]],
]);

it('declares the next day a public holiday when a public holiday falls on a sunday', function () {
    // Vesak Day 2026 is on Sunday 31 May.
    $holidays = Holidays::for(country: 'sg', year: 2026)->get();

    expect(findDate($holidays, 'Vesak Day')?->format('Y-m-d'))->toBe('2026-05-31');
    expect(findDate($holidays, 'Vesak Day (observed)')?->format('Y-m-d'))->toBe('2026-06-01');

    $observed = array_values(array_filter(
        $holidays,
        fn (Holiday $holiday): bool => $holiday->type === HolidayType::Observed,
    ));

    expect(array_map(fn (Holiday $holiday): string => $holiday->name, $observed))->toBe([
        'Vesak Day (observed)',
        'National Day (observed)',
        'Deepavali (observed)',
    ]);
});

it('skips a day that is already a public holiday when moving a sunday holiday', function () {
    // Chinese New Year 2023 is on Sunday 22 and Monday 23 January, so the extra day is Tuesday.
    $holidays = Holidays::for(country: 'sg', year: 2023)->get();

    expect(findDate($holidays, 'Chinese New Year')?->format('Y-m-d'))->toBe('2023-01-22');
    expect(findDate($holidays, 'Chinese New Year Day 2')?->format('Y-m-d'))->toBe('2023-01-23');
    expect(findDate($holidays, 'Chinese New Year (observed)')?->format('Y-m-d'))->toBe('2023-01-24');
});

it('does not move a public holiday that falls on a saturday', function () {
    // National Day 2025 is on Saturday 9 August.
    $holidays = Holidays::for(country: 'sg', year: 2025)->get();

    expect(findDate($holidays, 'National Day')?->format('Y-m-d'))->toBe('2025-08-09');
    expect(findDate($holidays, 'National Day (observed)'))->toBeNull();
});

it('throws an exception for years without published dates', function (int $year) {
    Holidays::for(country: 'sg', year: $year)->get();
})->with([2019, 2028])->throws(InvalidYear::class);
