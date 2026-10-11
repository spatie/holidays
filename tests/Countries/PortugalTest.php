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
    foreach (Portugal::regions() as $region) {
        $regional = array_filter(
            Holidays::for(country: 'pt', year: 2026, region: $region)->get(),
            fn ($holiday) => $holiday->type === HolidayType::Regional,
        );

        expect($regional)->not()->toBeEmpty($region);
    }
});

it('can calculate portuguese municipal holidays that depend on a weekday', function () {
    // Maia: Monday after the second Sunday of July
    $maia = Holidays::for(country: 'pt', year: 2026, region: 'PT-1306')->get();

    expect($maia[array_key_first(array_filter($maia, fn ($h) => $h->name === 'Nossa Senhora do Bom Despacho'))]->date->toDateString())->toBe('2026-07-13');

    // Matosinhos: Tuesday after Pentecost
    $matosinhos = Holidays::for(country: 'pt', year: 2026, region: 'PT-1308')->get();

    expect($matosinhos[array_key_first(array_filter($matosinhos, fn ($h) => $h->name === 'Terça-feira de Pentecostes'))]->date->toDateString())->toBe('2026-05-26');
});

it('throws for an unknown portuguese region', function () {
    Portugal::make('PT-9999');
})->throws(InvalidRegion::class);
