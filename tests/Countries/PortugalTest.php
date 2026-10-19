<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Portugal;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holidays;
use Spatie\Holidays\HolidayType;

it('can calculate portuguese holidays', function () {
    CarbonImmutable::setTestNow('2026-01-01');

    $holidays = Holidays::for(country: 'pt')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});

it('can calculate portuguese date based municipal holidays', function () {
    CarbonImmutable::setTestNow('2026-01-01');

    $holidays = Holidays::for(Portugal::make('PT-1106'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate portuguese easter based municipal holidays', function () {
    CarbonImmutable::setTestNow('2026-01-01');

    $holidays = Holidays::for(Portugal::make('PT-0103'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('only adds the municipal holiday of the given region', function () {
    $national = Holidays::for(country: 'pt', year: 2026)->get();
    $lisbon = Holidays::for(country: 'pt', year: 2026, region: 'PT-1106')->get();

    expect($lisbon)->toHaveCount(count($national) + 1);

    $regional = array_values(array_filter($lisbon, fn ($holiday) => $holiday->type === HolidayType::Regional));

    expect($regional)->toHaveCount(1)
        ->and($regional[0]->name)->toBe('Santo António')
        ->and($regional[0]->region)->toBe('PT-1106');
});

it('has a municipal holiday for every portuguese region', function () {
    expect(Portugal::regions())->toHaveCount(308)
        ->and(array_unique(Portugal::regions()))->toHaveCount(308);

    foreach (Portugal::regions() as $region) {
        $regional = array_filter(
            Holidays::for(country: 'pt', year: 2026, region: $region)->get(),
            fn ($holiday) => $holiday->type === HolidayType::Regional,
        );

        expect($regional)->toHaveCount(1, $region);
    }
});

it('uses the municipal holiday applicable to the year in Ponte de Lima', function (int $year, string $name, string $date) {
    $holidays = Holidays::for(country: 'pt', year: $year, region: 'PT-1607')->get();

    expect(findDate($holidays, $name)?->toDateString())->toBe($date);
})->with([
    [2023, 'Nossa Senhora das Dores', '2023-09-12'],
    [2024, 'Nossa Senhora das Dores', '2024-09-10'],
    [2025, 'Outorgação do Foral a vila por D. Teresa', '2025-03-04'],
    [2026, 'Outorgação do Foral a vila por D. Teresa', '2026-03-04'],
]);

it('can calculate portuguese municipal holidays that depend on a weekday', function (string $region, int $year, string $name, string $date) {
    $holidays = Holidays::for(country: 'pt', year: $year, region: $region)->get();

    expect(findDate($holidays, $name)?->toDateString())->toBe($date);
})->with([
    ['PT-1306', 2026, 'Nossa Senhora do Bom Despacho', '2026-07-13'],
    ['PT-1306', 2027, 'Nossa Senhora do Bom Despacho', '2027-07-12'],
    ['PT-1308', 2026, 'Terça-feira de Pentecostes', '2026-05-26'],
    ['PT-1308', 2027, 'Terça-feira de Pentecostes', '2027-05-18'],
    ['PT-1305', 2022, 'Nosso Senhor dos Aflitos', '2022-08-01'],
    ['PT-0511', 2022, 'Nossa Senhora da Alagada', '2022-08-29'],
]);

it('throws for an unknown portuguese region', function () {
    Portugal::make('PT-9999');
})->throws(InvalidRegion::class);
