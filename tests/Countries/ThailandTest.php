<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\Holidays;
use Spatie\Holidays\HolidayType;

it('can calculate thailand holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'th')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('matches the weekday holidays published by the bank of thailand', function (int $year, array $expectedDates) {
    $holidays = Holidays::for(country: 'th', year: $year)->get();

    $weekdays = array_filter($holidays, fn (Holiday $holiday): bool => $holiday->date->isWeekday());

    $dates = array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $weekdays);

    expect(array_values($dates))->toBe($expectedDates);
})->with([
    [2022, [
        '2022-01-03', '2022-02-16', '2022-04-06', '2022-04-13', '2022-04-14', '2022-04-15', '2022-05-02',
        '2022-05-04', '2022-05-16', '2022-06-03', '2022-07-13', '2022-07-28', '2022-07-29', '2022-08-12',
        '2022-10-13', '2022-10-14', '2022-10-24', '2022-12-05', '2022-12-12',
    ]],
    [2023, [
        '2023-01-02', '2023-03-06', '2023-04-06', '2023-04-13', '2023-04-14', '2023-05-01', '2023-05-04',
        '2023-05-05', '2023-06-05', '2023-07-28', '2023-08-01', '2023-08-14', '2023-10-13', '2023-10-23',
        '2023-12-05', '2023-12-11', '2023-12-29',
    ]],
    [2024, [
        '2024-01-01', '2024-02-26', '2024-04-08', '2024-04-12', '2024-04-15', '2024-04-16', '2024-05-01',
        '2024-05-06', '2024-05-22', '2024-06-03', '2024-07-22', '2024-07-29', '2024-08-12', '2024-10-14',
        '2024-10-23', '2024-12-05', '2024-12-10', '2024-12-31',
    ]],
    [2025, [
        '2025-01-01', '2025-02-12', '2025-04-07', '2025-04-14', '2025-04-15', '2025-05-01', '2025-05-05',
        '2025-05-12', '2025-06-02', '2025-06-03', '2025-07-10', '2025-07-28', '2025-08-11', '2025-08-12',
        '2025-10-13', '2025-10-23', '2025-12-05', '2025-12-10', '2025-12-31',
    ]],
    [2026, [
        '2026-01-01', '2026-01-02', '2026-03-03', '2026-04-06', '2026-04-13', '2026-04-14', '2026-04-15',
        '2026-05-01', '2026-05-04', '2026-06-01', '2026-06-03', '2026-07-28', '2026-07-29', '2026-08-12',
        '2026-10-13', '2026-10-23', '2026-12-07', '2026-12-10', '2026-12-16', '2026-12-31',
    ]],
    [2027, [
        '2027-01-01', '2027-02-22', '2027-04-06', '2027-04-13', '2027-04-14', '2027-04-15', '2027-05-03',
        '2027-05-04', '2027-05-20', '2027-06-03', '2027-07-19', '2027-07-28', '2027-08-12', '2027-10-13',
        '2027-10-25', '2027-12-06', '2027-12-10', '2027-12-31',
    ]],
]);

it('keeps a weekend holiday and adds its substitution day as an observed holiday', function () {
    $holidays = Holidays::for(country: 'th', year: 2027, locale: 'en')->get();

    expect(findDate($holidays, 'Makha Bucha Day')?->format('Y-m-d'))->toBe('2027-02-21');
    expect(findDate($holidays, 'Substitution for Makha Bucha Day')?->format('Y-m-d'))->toBe('2027-02-22');

    $observed = array_values(array_filter(
        $holidays,
        fn (Holiday $holiday): bool => $holiday->type === HolidayType::Observed,
    ));

    expect(array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $observed))->toBe([
        '2027-02-22', '2027-05-03', '2027-07-19', '2027-10-25', '2027-12-06',
    ]);
});

it('lists a weekend holiday only when the bank of thailand names it for a substitution day', function (int $year, array $expectedDates) {
    $holidays = Holidays::for(country: 'th', year: $year)->get();

    $weekend = array_filter($holidays, fn (Holiday $holiday): bool => $holiday->date->isWeekend());

    $dates = array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $weekend);

    expect(array_values(array_unique($dates)))->toBe($expectedDates);
})->with([
    [2022, ['2022-01-01', '2022-05-01', '2022-05-15', '2022-10-23', '2022-12-10', '2022-12-31']],
    [2023, ['2023-01-01', '2023-06-03', '2023-08-12', '2023-12-10', '2023-12-31']],
    [2024, ['2024-02-24', '2024-04-06', '2024-04-13', '2024-04-14', '2024-05-04', '2024-07-20', '2024-07-28', '2024-10-13']],
    [2025, ['2025-04-06', '2025-05-04', '2025-05-11']],
    [2026, ['2026-05-31', '2026-12-05']],
    [2027, ['2027-02-21', '2027-05-01', '2027-07-18', '2027-10-23', '2027-12-05']],
]);

it('leaves out a weekend holiday that got no substitution day', function (string $date) {
    expect(Holidays::for('th')->isHoliday($date))->toBeFalse();
})->with(['2023-04-15', '2023-04-17', '2025-04-13', '2025-04-16']);

it('uses one substitution day for two holidays that share a weekend', function () {
    $holidays = Holidays::for(country: 'th', year: 2023, locale: 'en')->get();

    expect(findDate($holidays, "H.M. Queen Suthida Bajrasudhabimalalakshana's Birthday")?->format('Y-m-d'))->toBe('2023-06-03');
    expect(findDate($holidays, 'Visakha Bucha Day')?->format('Y-m-d'))->toBe('2023-06-03');
    expect(findDate($holidays, "Substitution for H.M. Queen Suthida Bajrasudhabimalalakshana's Birthday and Visakha Bucha Day")?->format('Y-m-d'))
        ->toBe('2023-06-05');
});

it('lists the additional special holidays', function (int $year, array $expectedDates) {
    $holidays = Holidays::for(country: 'th', year: $year, locale: 'en')->get();

    $special = array_values(array_filter(
        $holidays,
        fn (Holiday $holiday): bool => $holiday->name === 'Additional special holiday',
    ));

    expect(array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $special))->toBe($expectedDates);
})->with([
    [2022, ['2022-07-29', '2022-10-14']],
    [2023, ['2023-05-05']],
    [2024, ['2024-04-12']],
    [2025, ['2025-06-02', '2025-08-11']],
    [2026, ['2026-01-02', '2026-12-16']],
    [2027, []],
]);

it('names the holidays in thai by default', function () {
    $holidays = Holidays::for(country: 'th', year: 2027)->get();

    expect(findDate($holidays, 'วันมาฆบูชา')?->format('Y-m-d'))->toBe('2027-02-21');
    expect(findDate($holidays, 'ชดเชยวันมาฆบูชา')?->format('Y-m-d'))->toBe('2027-02-22');
    expect(findDate($holidays, 'วันรัฐธรรมนูญ')?->format('Y-m-d'))->toBe('2027-12-10');
});

it('follows the announced name of a holiday in each year', function (int $year, string $name, string $date) {
    $holidays = Holidays::for(country: 'th', year: $year)->get();

    expect(findDate($holidays, $name)?->format('Y-m-d'))->toBe($date);
})->with([
    [2022, 'วันคล้ายวันสวรรคตพระบาทสมเด็จพระบรมชนกาธิเบศร มหาภูมิพลอดุลยเดชมหาราช บรมนาถบพิตร', '2022-10-13'],
    [2023, 'วันนวมินทรมหาราช', '2023-10-13'],
    [2026, 'วันเฉลิมพระชนมพรรษาสมเด็จพระนางเจ้าสิริกิติ์ พระบรมราชินีนาถ พระบรมราชชนนีพันปีหลวง และวันแม่แห่งชาติ', '2026-08-12'],
    [2027, 'วันคล้ายวันพระราชสมภพ สมเด็จพระนางเจ้าสิริกิติ์ พระบรมราชินีนาถ พระบรมราชชนนีพันปีหลวง และวันแม่แห่งชาติ', '2027-08-12'],
]);

it('has an english translation for every thailand holiday', function () {
    $translations = json_decode((string) file_get_contents(__DIR__.'/../../lang/th/en/holidays.json'), true);

    foreach (range(2022, 2027) as $year) {
        foreach (Holidays::for(country: 'th', year: $year)->get() as $holiday) {
            expect($translations)->toHaveKey($holiday->name);
        }
    }
});

it('excludes a cancelled substitution day and a holiday for bangkok only', function (string $date) {
    expect(Holidays::for('th')->isHoliday($date))->toBeFalse();
})->with(['2024-01-02', '2026-10-16']);

it('throws an exception for years without published dates', function (int $year) {
    Holidays::for(country: 'th', year: $year)->get();
})->with([2021, 2028])->throws(InvalidYear::class);
