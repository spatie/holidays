<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\Holidays;

it('can calculate saudi arabia holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'sa')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('matches the holidays announced by the ministry of human resources', function (int $year, array $expectedDates) {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'sa', year: $year)->get();

    $dates = array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $holidays);

    expect($dates)->toBe($expectedDates);
})->with([
    [2024, [
        '2024-02-22', '2024-04-09', '2024-04-10', '2024-04-11', '2024-04-12',
        '2024-06-15', '2024-06-16', '2024-06-17', '2024-06-18', '2024-09-23',
    ]],
    [2025, [
        '2025-02-22', '2025-03-30', '2025-03-31', '2025-04-01', '2025-04-02',
        '2025-06-05', '2025-06-06', '2025-06-07', '2025-06-08', '2025-09-23',
    ]],
    [2026, [
        '2026-02-22', '2026-03-19', '2026-03-20', '2026-03-21', '2026-03-22',
        '2026-05-26', '2026-05-27', '2026-05-28', '2026-05-29', '2026-09-23',
    ]],
]);

it('only includes founding day from 2022', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    expect(findDate(Holidays::for(country: 'sa', year: 2021)->get(), 'Founding Day'))->toBeNull()
        ->and(findDate(Holidays::for(country: 'sa', year: 2022)->get(), 'Founding Day')?->format('Y-m-d'))->toBe('2022-02-22');
});

it('includes both eid al-fitr holidays when they fall in the same year', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'sa', year: 2033)->get();

    $eidAlFitr = array_filter($holidays, fn (Holiday $holiday): bool => str_starts_with($holiday->name, 'Eid al-Fitr'));

    expect($eidAlFitr)->toHaveCount(8);
});

it('can translate saudi arabia holidays to arabic', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'sa', year: 2025, locale: 'ar')->get();

    expect(findDate($holidays, 'يوم التأسيس')?->format('Y-m-d'))->toBe('2025-02-22')
        ->and(findDate($holidays, 'عطلة عيد الفطر')?->format('Y-m-d'))->toBe('2025-03-30');
});
