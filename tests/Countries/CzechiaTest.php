<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate czech holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'cz')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('gives right holidays for specific years', function (int $year, array $containsHolidays) {
    $holidays = Holidays::for('cz', $year)->get();

    $allHolidaysSince1970 = [
        0 => 'Nový rok',
        1 => 'Nový rok; Den obnovy samostatného českého státu',
        2 => 'Svátek práce',
        3 => 'Výročí osvobození Československa Sovětskou armádou',
        4 => 'Den osvobození od fašismu',
        5 => 'Den osvobození',
        6 => 'Den vítězství',
        7 => 'Den slovanských věrozvěstů Cyrila a Metoděje',
        8 => 'Den upálení mistra Jana Husa',
        9 => 'Den české státnosti',
        10 => 'Vyhlášení samostatnosti ČSR; Schválení zákona o federaci',
        11 => 'Den znárodnění',
        12 => 'Vyhlášení samostatnosti ČSR; Schválení zákona o federaci; Den znárodnění',
        13 => 'Den vzniku samostatného československého státu',
        14 => 'Den boje za svobodu a demokracii a Mezinárodní den studentstva',
        15 => 'Štědrý den',
        16 => '1. svátek vánoční',
        17 => '2. svátek vánoční',
        // Variable:
        18 => 'Velikonoční pondělí',
        19 => 'Velký pátek',
    ];

    expect($holidays)->toBeArray();

    $expectedHolidays = array_map(
        static fn (int $index) => $allHolidaysSince1970[$index],
        $containsHolidays
    );

    $givenNames = array_map(
        static fn (array $holidayProperties) => $holidayProperties['name'],
        $holidays
    );

    expect($givenNames)->toEqualCanonicalizing($expectedHolidays);
})->with([
    [1970, [0, 18, 2, 3, 10, 16, 17]],
    [1975, [0, 18, 2, 3, 16, 17]],
    [1980, [0, 18, 2, 3, 16, 17]],
    [1985, [0, 18, 2, 3, 16, 17]],
    [1990, [0, 18, 2, 3, 7, 8, 13, 15, 16, 17]],
    [1995, [0, 18, 2, 4, 7, 8, 13, 15, 16, 17]],
    [2000, [0, 18, 2, 4, 7, 8, 9, 13, 14, 15, 16, 17]],
    [2005, [1, 18, 2, 6, 7, 8, 9, 13, 14, 15, 16, 17]],
    [2010, [1, 18, 2, 6, 7, 8, 9, 13, 14, 15, 16, 17]],
    [2015, [1, 18, 2, 6, 7, 8, 9, 13, 14, 15, 16, 17]],
    [2020, [1, 19, 18, 2, 6, 7, 8, 9, 13, 14, 15, 16, 17]],
]);
