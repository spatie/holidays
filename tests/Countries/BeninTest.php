<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Benin;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\Holidays;

it('can calculate benin holidays', function (int $year) {
    CarbonImmutable::setTestNow("{$year}-01-01");

    $holidays = Holidays::for(country: 'bj', year: $year)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
})->with([2024, 2025]);

it('observes the annual traditional religions festival as set by law', function (int $year, array $dates) {
    $holidays = Holidays::for(country: 'bj', year: $year)->get();

    $festival = array_values(array_filter(
        $holidays,
        fn (Holiday $holiday): bool => $holiday->name === 'Fête annuelle des religions traditionnelles',
    ));

    expect(array_map(fn (Holiday $holiday): string => $holiday->date->format('Y-m-d'), $festival))->toBe($dates);
})->with([
    'not a holiday before law 97-031' => [1997, []],
    'first 10 January under law 97-031' => [1998, ['1998-01-10']],
    'last 10 January under law 97-031' => [2024, ['2024-01-10']],
    'second friday and the thursday before it under law 2024-32' => [2025, ['2025-01-09', '2025-01-10']],
    'when january starts on a thursday' => [2026, ['2026-01-08', '2026-01-09']],
    'when january starts on a friday' => [2027, ['2027-01-07', '2027-01-08']],
]);

it('observes ascension day on a thursday', function (int $year, string $date) {
    $ascension = findDate(Holidays::for(country: 'bj', year: $year)->get(), "Jour de l'Ascension");

    expect($ascension?->format('Y-m-d'))->toBe($date);
    expect($ascension?->isThursday())->toBeTrue();
})->with([
    [2024, '2024-05-09'],
    [2025, '2025-05-29'],
]);

it('calculates easter-based holidays regardless of the current time and timezone', function (string $now, string $timezone) {
    $originalTimezone = date_default_timezone_get();
    $originalNow = CarbonImmutable::getTestNow();

    try {
        date_default_timezone_set($timezone);
        CarbonImmutable::setTestNow($now);

        $holidays = Holidays::for('bj', 2025);

        expect(findDate($holidays->get(), 'Lundi de Pâques')?->format('Y-m-d'))->toBe('2025-04-21')
            ->and(findDate($holidays->get(), "Jour de l'Ascension")?->format('Y-m-d'))->toBe('2025-05-29')
            ->and(findDate($holidays->get(), 'Lundi de Pentecôte')?->format('Y-m-d'))->toBe('2025-06-09')
            ->and($holidays->isHoliday('2025-05-29'))->toBeTrue()
            ->and($holidays->isHoliday('2025-05-28'))->toBeFalse()
            ->and($holidays->isHoliday('2025-05-30'))->toBeFalse();
    } finally {
        CarbonImmutable::setTestNow($originalNow);
        date_default_timezone_set($originalTimezone);
    }
})->with([
    'just after midnight' => '2025-01-01 00:30:00',
    'just before midnight' => '2025-01-01 23:30:00',
])->with(['UTC', 'Asia/Tokyo', 'America/Los_Angeles']);

it('observes each islamic holiday on a single day', function (int $year) {
    $names = array_map(
        fn (Holiday $holiday): string => $holiday->name,
        Holidays::for(country: 'bj', year: $year)->get(),
    );

    $islamic = array_values(array_filter(
        $names,
        fn (string $name): bool => preg_match('/Ramadan|Tabaski|Maouloud/', $name) === 1,
    ));

    sort($islamic);

    expect($islamic)->toBe(['Jour de la Tabaski', 'Jour du Ramadan', 'Journée Maouloud']);
})->with([1970, 2024, 2037]);

it('numbers a second occurrence of an islamic holiday in the same year', function () {
    $benin = new class extends Benin
    {
        /** @return array<Holiday> */
        public function islamicHolidays(int $year, array $holidays, string $label): array
        {
            return $this->getIslamicHolidays($year, $holidays, $label);
        }
    };

    expect(formatDates($benin->islamicHolidays(2000, [2000 => ['01-08', '12-27']], 'Jour du Ramadan')))->toBe([
        ['name' => 'Jour du Ramadan', 'date' => '2000-01-08'],
        ['name' => '2. Jour du Ramadan', 'date' => '2000-12-27'],
    ]);
});
