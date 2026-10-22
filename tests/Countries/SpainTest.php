<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Spain;
use Spatie\Holidays\Holidays;

// 2027
it('can calculate spanish regional holidays 2027', function () {
    CarbonImmutable::setTestNow('2027-01-01');

    $holidays = Holidays::for(Spain::make('es-cn'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();
});

it('can calculate spanish regional holidays 2027 by date', function (string $region, string $date, string $name) {
    $holidays = Holidays::for(Spain::make($region));

    expect($holidays->isHoliday($date))->toBeTrue()
        ->and($holidays->getName($date))->toBe($name);
})->with([
    'Andalucía' => ['es-an', '2027-03-01', 'Día de Andalucía'],
    'Extremadura' => ['es-ex', '2027-10-11', 'Sustitución del 15 de agosto'],
    'País Vasco' => ['es-pv', '2027-10-07', 'Aniversario del primer Gobierno de Euskadi'],
    'Canarias' => ['es-cn', '2027-08-16', 'Lunes siguiente a la Asunción de la Virgen'],
]);

it('does not include regional holidays that fall on a Sunday in 2027', function (string $region, string $date) {
    expect(Holidays::for(Spain::make($region))->isHoliday($date))->toBeFalse();
})->with([
    'Madrid' => ['es-md', '2027-05-02'],
    'Canarias' => ['es-cn', '2027-05-30'],
]);

// 2025
it('can calculate spanish holidays 2025', function () {
    CarbonImmutable::setTestNow('2025-01-01');

    $holidays = Holidays::for(country: 'es')->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

it('can calculate spanish regional holidays 2025', function () {
    CarbonImmutable::setTestNow('2025-01-01');

    $holidays = Holidays::for(Spain::make('es-ct'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

// 2024
it('can calculate spanish holidays 2024', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'es')->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

it('can calculate spanish regional holidays 2024', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(Spain::make('es-ar'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();
});

// 2023
it('can calculate spanish holidays 2023', function () {
    CarbonImmutable::setTestNow('2023-01-01');

    $holidays = Holidays::for(country: 'es')->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();
});

it(/**
 * @throws \JsonException
 */ 'can calculate spanish regional holidays 2023', function () {
    CarbonImmutable::setTestNow('2023-01-01');

    $holidays = Holidays::for(Spain::make('es-ar'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

// 2022
it('can calculate spanish holidays 2022', function () {
    CarbonImmutable::setTestNow('2022-01-01');

    $holidays = Holidays::for(country: 'es')->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();

});

it('can calculate spanish regional holidays 2022', function () {
    CarbonImmutable::setTestNow('2022-01-01');

    $holidays = Holidays::for(Spain::make('es-ar'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();
});
