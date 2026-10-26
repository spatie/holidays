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
        fn (Holiday $holiday): bool => $holiday->name === 'Fête annuelle des réligions traditionnelles',
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
    $ascension = findDate(Holidays::for(country: 'bj', year: $year)->get(), 'Jour de l’Ascension');

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
            ->and(findDate($holidays->get(), 'Jour de l’Ascension')?->format('Y-m-d'))->toBe('2025-05-29')
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

    expect($islamic)->toBe(['Fête de Ramadan - Jour 1', 'Fête de la Tabaski - Jour 1', 'Jour du Maouloud - Jour 1']);
})->with([1970, 2024, 2037]);

it('preserves existing holiday names', function (string $date, string $name) {
    expect(Holidays::for('bj', 2024)->getName($date))->toBe($name);
})->with([
    ['2024-01-10', 'Fête annuelle des réligions traditionnelles'],
    ['2024-04-10', 'Fête de Ramadan - Jour 1'],
    ['2024-05-01', 'Fete du travail'],
    ['2024-05-09', 'Jour de l’Ascension'],
    ['2024-06-17', 'Fête de la Tabaski - Jour 1'],
    ['2024-08-01', "Fête de l'indépendance"],
    ['2024-08-15', "Jour de l'assomption"],
    ['2024-09-15', 'Jour du Maouloud - Jour 1'],
    ['2024-12-25', 'Jour de Noel'],
]);

it('preserves custom multi-day holidays and the preparation hook across years', function () {
    $benin = new class extends Benin
    {
        /** @return array<Holiday> */
        protected function allHolidays(int $year): array
        {
            return $this->getIslamicHolidays(
                year: $year,
                holidays: [2023 => '12-31', 2024 => ['06-11', '12-31'], 2025 => '12-21'],
                label: 'Custom festival',
                day: 2,
            );
        }

        protected function prepareHolidays(CarbonImmutable $holiday, int $day, string $label, int $filterYear, string $prefix = ''): array
        {
            return parent::prepareHolidays($holiday, $day, "{$label} personnalisé", $filterYear, $prefix);
        }
    };

    expect(formatDates(Holidays::for($benin, 2024)->get()))->toBe([
        ['name' => 'Custom festival personnalisé - Jour 2', 'date' => '2024-01-01'],
        ['name' => '2. Custom festival personnalisé - Jour 1', 'date' => '2024-06-11'],
        ['name' => '2. Custom festival personnalisé - Jour 2', 'date' => '2024-06-12'],
        ['name' => '3. Custom festival personnalisé - Jour 1', 'date' => '2024-12-31'],
    ]);
});
