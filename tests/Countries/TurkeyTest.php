<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Turkey;
use Spatie\Holidays\Holidays;
use Spatie\Holidays\HolidayType;

afterEach(function () {
    CarbonImmutable::setTestNow();
});

it('can calculate turkey holidays', function ($year) {
    CarbonImmutable::setTestNow($year.'-01-01');

    $holidays = Holidays::for(country: 'tr')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
})->with([1970, 1971, 1973, 1974, 1975, 1999, 2000, 2001, 2005, 2006, 2007, 2008, 2009, 2016, 2017, 2021, 2022, 2023, 2024, 2025, 2032, 2033, 2034, 2037]);

it('places eid al-adha 1971 on 10 dhu al-hijjah 1390', function () {
    $holidays = Holidays::for(country: 'tr', year: 1971)->get();

    expect(findDate($holidays, 'Kurban Bayramı Arifesi')?->format('Y-m-d'))->toBe('1971-02-05');
    expect(findDate($holidays, 'Kurban Bayramı 1. Gün')?->format('Y-m-d'))->toBe('1971-02-06');
    expect(findDate($holidays, 'Kurban Bayramı 4. Gün')?->format('Y-m-d'))->toBe('1971-02-09');
});

it('returns every day of the eid holidays regardless of the time of day', function (string $time) {
    CarbonImmutable::setTestNow("2027-01-01 {$time}");

    $holidays = Holidays::for(country: 'tr', year: 2027)->get();
    $religiousHolidays = Holidays::for(country: 'tr', year: 2027, locale: 'en')->get(HolidayType::Religious);

    expect(findDate($holidays, 'Ramazan Bayramı 3. Gün')?->format('Y-m-d'))->toBe('2027-03-11');
    expect(findDate($holidays, 'Kurban Bayramı 4. Gün')?->format('Y-m-d'))->toBe('2027-05-19');

    expect(formatDates($religiousHolidays))->toBe([
        ['name' => 'Eid al-Fitr Eve', 'date' => '2027-03-08'],
        ['name' => 'Eid al-Fitr', 'date' => '2027-03-09'],
        ['name' => 'Eid al-Fitr Day 2', 'date' => '2027-03-10'],
        ['name' => 'Eid al-Fitr Day 3', 'date' => '2027-03-11'],
        ['name' => 'Eid al-Adha Eve', 'date' => '2027-05-15'],
        ['name' => 'Eid al-Adha', 'date' => '2027-05-16'],
        ['name' => 'Eid al-Adha Day 2', 'date' => '2027-05-17'],
        ['name' => 'Eid al-Adha Day 3', 'date' => '2027-05-18'],
        ['name' => 'Eid al-Adha Day 4', 'date' => '2027-05-19'],
    ]);

    $nationalHolidays = Holidays::for(country: 'tr', year: 2027, locale: 'en')->get(HolidayType::National);

    expect(findDate($nationalHolidays, 'Commemoration of Atatürk, Youth and Sports Day')?->format('Y-m-d'))->toBe('2027-05-19');
})->with(['00:00:00', '15:30:00', '23:59:59.999999']);

it('returns complete eid periods at date boundaries', function (int $year, int $totalDays, array $expected) {
    CarbonImmutable::setTestNow('2027-01-01 15:30:00');

    $periods = (new Turkey)->eidAlAdha($year, $totalDays);
    $period = $periods[array_key_last($periods)];

    expect(array_map(fn ($day) => $day->format('Y-m-d'), iterator_to_array($period)))->toBe($expected);
})->with([
    'single day' => [2027, 1, ['2027-05-16']],
    'month boundary' => [2020, 4, ['2020-07-31', '2020-08-01', '2020-08-02', '2020-08-03']],
    'year boundary' => [2006, 4, ['2006-12-31', '2007-01-01', '2007-01-02', '2007-01-03']],
]);
