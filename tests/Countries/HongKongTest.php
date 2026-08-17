<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\Holidays;

it('can calculate hong kong holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'hk')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});

it('matches the general holidays gazetted by the hong kong government', function (int $year, array $expectedDates) {
    $holidays = Holidays::for(country: 'hk', year: $year)->get();

    $dates = array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $holidays);

    expect($dates)->toBe($expectedDates);
})->with([
    [2020, [
        '2020-01-01', '2020-01-25', '2020-01-27', '2020-01-28', '2020-04-04', '2020-04-10',
        '2020-04-11', '2020-04-13', '2020-04-30', '2020-05-01', '2020-06-25', '2020-07-01',
        '2020-10-01', '2020-10-02', '2020-10-26', '2020-12-25', '2020-12-26',
    ]],
    [2021, [
        '2021-01-01', '2021-02-12', '2021-02-13', '2021-02-15', '2021-04-02', '2021-04-03',
        '2021-04-05', '2021-04-06', '2021-05-01', '2021-05-19', '2021-06-14', '2021-07-01',
        '2021-09-22', '2021-10-01', '2021-10-14', '2021-12-25', '2021-12-27',
    ]],
    [2022, [
        '2022-01-01', '2022-02-01', '2022-02-02', '2022-02-03', '2022-04-05', '2022-04-15',
        '2022-04-16', '2022-04-18', '2022-05-02', '2022-05-09', '2022-06-03', '2022-07-01',
        '2022-09-12', '2022-10-01', '2022-10-04', '2022-12-26', '2022-12-27',
    ]],
    [2023, [
        '2023-01-02', '2023-01-23', '2023-01-24', '2023-01-25', '2023-04-05', '2023-04-07',
        '2023-04-08', '2023-04-10', '2023-05-01', '2023-05-26', '2023-06-22', '2023-07-01',
        '2023-09-30', '2023-10-02', '2023-10-23', '2023-12-25', '2023-12-26',
    ]],
    [2024, [
        '2024-01-01', '2024-02-10', '2024-02-12', '2024-02-13', '2024-03-29', '2024-03-30',
        '2024-04-01', '2024-04-04', '2024-05-01', '2024-05-15', '2024-06-10', '2024-07-01',
        '2024-09-18', '2024-10-01', '2024-10-11', '2024-12-25', '2024-12-26',
    ]],
    [2025, [
        '2025-01-01', '2025-01-29', '2025-01-30', '2025-01-31', '2025-04-04', '2025-04-18',
        '2025-04-19', '2025-04-21', '2025-05-01', '2025-05-05', '2025-05-31', '2025-07-01',
        '2025-10-01', '2025-10-07', '2025-10-29', '2025-12-25', '2025-12-26',
    ]],
    [2026, [
        '2026-01-01', '2026-02-17', '2026-02-18', '2026-02-19', '2026-04-03', '2026-04-04',
        '2026-04-06', '2026-04-07', '2026-05-01', '2026-05-25', '2026-06-19', '2026-07-01',
        '2026-09-26', '2026-10-01', '2026-10-19', '2026-12-25', '2026-12-26',
    ]],
]);

it('moves a holiday that falls on a sunday to the next free day', function () {
    // The first day of January 2023 was a Sunday.
    $holidays = Holidays::for(country: 'hk', year: 2023)->get();
    expect(findDate($holidays, '一月一日'))->toBeNull();
    expect(findDate($holidays, '一月一日翌日')?->format('Y-m-d'))->toBe('2023-01-02');

    // Lunar New Year's Day 2024 fell on a Saturday, so the second day fell on a
    // Sunday and moved past the third day onto the fourth.
    $holidays = Holidays::for(country: 'hk', year: 2024)->get();
    expect(findDate($holidays, '農曆年初二'))->toBeNull();
    expect(findDate($holidays, '農曆年初四')?->format('Y-m-d'))->toBe('2024-02-13');

    // Ching Ming 2026 falls on a Sunday and has to move past Easter Monday.
    $holidays = Holidays::for(country: 'hk', year: 2026)->get();
    expect(findDate($holidays, '清明節'))->toBeNull();
    expect(findDate($holidays, '清明節翌日')?->format('Y-m-d'))->toBe('2026-04-07');

    // Christmas Day 2022 fell on a Sunday, so both December holidays moved on.
    $holidays = Holidays::for(country: 'hk', year: 2022)->get();
    expect(findDate($holidays, '聖誕節後第一個周日')?->format('Y-m-d'))->toBe('2022-12-26');
    expect(findDate($holidays, '聖誕節後第二個周日')?->format('Y-m-d'))->toBe('2022-12-27');
});

it('alternates ching ming festival between 4 and 5 april', function () {
    $chingMingDates = [];

    // None of these years have Ching Ming on a Sunday, so it is never moved.
    foreach ([2027, 2028, 2029, 2030, 2031, 2033] as $year) {
        $holidays = Holidays::for(country: 'hk', year: $year)->get();

        $chingMingDates[$year] = findDate($holidays, '清明節')?->format('m-d');
    }

    expect($chingMingDates)->toBe([
        2027 => '04-05',
        2028 => '04-04',
        2029 => '04-04',
        2030 => '04-05',
        2031 => '04-05',
        2033 => '04-04',
    ]);
});

it('has an english translation for every hong kong holiday', function () {
    $translations = json_decode((string) file_get_contents(__DIR__.'/../../lang/hk/en/holidays.json'), true);

    foreach (range(2000, 2050) as $year) {
        foreach (Holidays::for(country: 'hk', year: $year)->get() as $holiday) {
            expect($translations)->toHaveKey($holiday->name);
        }
    }
});
