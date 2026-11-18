<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\Holidays;
use Spatie\Holidays\HolidayType;

it('can calculate china holidays', function () {
    CarbonImmutable::setTestNow('2025-01-01');

    $holidays = Holidays::for(country: 'cn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('matches the holiday periods announced by the state council', function (int $year, array $expectedDates) {
    $holidays = Holidays::for(country: 'cn', year: $year, locale: 'en')->get();

    $dates = [];

    foreach ($holidays as $holiday) {
        $dates[$holiday->name][] = $holiday->date->format('m-d');
    }

    expect($dates)->toBe($expectedDates);
})->with([
    [2024, [
        "New Year's Day" => ['01-01'],
        'Spring Festival' => ['02-10', '02-11', '02-12', '02-13', '02-14', '02-15', '02-16', '02-17'],
        'Qingming Festival' => ['04-04', '04-05', '04-06'],
        'Labor Day' => ['05-01', '05-02', '05-03', '05-04', '05-05'],
        'Dragon Boat Festival' => ['06-08', '06-09', '06-10'],
        'Mid-Autumn Festival' => ['09-15', '09-16', '09-17'],
        'National Day' => ['10-01', '10-02', '10-03', '10-04', '10-05', '10-06', '10-07'],
    ]],
    [2025, [
        "New Year's Day" => ['01-01'],
        'Spring Festival' => ['01-28', '01-29', '01-30', '01-31', '02-01', '02-02', '02-03', '02-04'],
        'Qingming Festival' => ['04-04', '04-05', '04-06'],
        'Labor Day' => ['05-01', '05-02', '05-03', '05-04', '05-05'],
        'Dragon Boat Festival' => ['05-31', '06-01', '06-02'],
        'National Day and Mid-Autumn Festival' => ['10-01', '10-02', '10-03', '10-04', '10-05', '10-06', '10-07', '10-08'],
    ]],
    [2026, [
        "New Year's Day" => ['01-01', '01-02', '01-03'],
        'Spring Festival' => ['02-15', '02-16', '02-17', '02-18', '02-19', '02-20', '02-21', '02-22', '02-23'],
        'Qingming Festival' => ['04-04', '04-05', '04-06'],
        'Labor Day' => ['05-01', '05-02', '05-03', '05-04', '05-05'],
        'Dragon Boat Festival' => ['06-19', '06-20', '06-21'],
        'Mid-Autumn Festival' => ['09-25', '09-26', '09-27'],
        'National Day' => ['10-01', '10-02', '10-03', '10-04', '10-05', '10-06', '10-07'],
    ]],
    [2027, [
        "New Year's Day" => ['01-01', '01-02', '01-03'],
        'Spring Festival' => ['02-05', '02-06', '02-07', '02-08', '02-09', '02-10', '02-11', '02-12', '02-13'],
        'Qingming Festival' => ['04-03', '04-04', '04-05'],
        'Labor Day' => ['05-01', '05-02', '05-03', '05-04', '05-05'],
        'Dragon Boat Festival' => ['06-09'],
        'Mid-Autumn Festival' => ['09-15'],
        'National Day' => ['10-01', '10-02', '10-03', '10-04', '10-05', '10-06', '10-07'],
    ]],
]);

it('returns the announced number of days off', function (int $year, int $days) {
    expect(Holidays::for(country: 'cn', year: $year)->get())->toHaveCount($days);
})->with([
    [2024, 30],
    [2025, 28],
    [2026, 33],
    [2027, 29],
]);

it('returns every day of a period as a national holiday, weekends included', function () {
    $holidays = Holidays::for(country: 'cn', year: 2026)->get();

    foreach ($holidays as $holiday) {
        expect($holiday->type)->toBe(HolidayType::National);
    }

    $weekend = array_filter($holidays, fn (Holiday $holiday): bool => $holiday->date->isWeekend());

    expect($weekend)->not()->toBeEmpty();
});

it('does not list the days around a period', function (string $date) {
    expect(Holidays::for('cn')->isHoliday($date))->toBeFalse();
})->with([
    '2024-01-02', '2024-02-09', '2024-02-18', '2024-06-07', '2024-09-18',
    '2025-01-02', '2025-01-27', '2025-02-05', '2025-10-09',
    '2026-01-04', '2026-02-14', '2026-02-24', '2026-09-28', '2026-10-08',
    '2027-01-04', '2027-02-04', '2027-02-14', '2027-06-08', '2027-06-10', '2027-09-14', '2027-09-16',
]);

it('names the holidays in chinese by default', function () {
    $holidays = Holidays::for(country: 'cn', year: 2026)->get();

    expect(findDate($holidays, '元旦')?->format('Y-m-d'))->toBe('2026-01-01');
    expect(findDate($holidays, '春节')?->format('Y-m-d'))->toBe('2026-02-15');
    expect(findDate($holidays, '中秋节')?->format('Y-m-d'))->toBe('2026-09-25');
    expect(findDate($holidays, '国庆节')?->format('Y-m-d'))->toBe('2026-10-01');
});

it('names the combined period of 2025 after both holidays', function () {
    $holidays = Holidays::for(country: 'cn', year: 2025)->get();

    expect(findDate($holidays, '国庆节、中秋节')?->format('Y-m-d'))->toBe('2025-10-01');
    expect(findDate($holidays, '国庆节'))->toBeNull();
    expect(findDate($holidays, '中秋节'))->toBeNull();
});

it('has an english translation for every china holiday', function () {
    $translations = json_decode((string) file_get_contents(__DIR__.'/../../lang/cn/en/holidays.json'), true);

    foreach (range(2024, 2027) as $year) {
        foreach (Holidays::for(country: 'cn', year: $year)->get() as $holiday) {
            expect($translations)->toHaveKey($holiday->name);
        }
    }
});

it('throws an exception for years without an announcement', function (int $year) {
    Holidays::for(country: 'cn', year: $year)->get();
})->with([2023, 2028])->throws(InvalidYear::class);
