<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Australia;
use Spatie\Holidays\Holidays;

it('can calculate australian holidays', function () {
    CarbonImmutable::setTestNow('2024-01-22');

    $holidays = Holidays::for(country: 'au')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate australian holidays for a specific year', function () {
    CarbonImmutable::setTestNow('2024-01-22');

    $holidays = Holidays::for(country: 'au', year: 2025)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate regional australian holidays', function () {
    CarbonImmutable::setTestNow('2024-01-22');

    $holidays = Holidays::for(Australia::make('vic'))->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate the day before afl grand final', function () {
    CarbonImmutable::setTestNow('2021-01-22');

    $holidays = Holidays::for(Australia::make('vic'))->get();

    expect(findDate($holidays, 'Friday before AFL Grand Final'))
        ->toEqual(CarbonImmutable::create(2021, 9, 24));
});

it('can calculate the day before afl grand final during lockdown', function () {
    CarbonImmutable::setTestNow('2020-01-22');

    $holidays = Holidays::for(Australia::make('vic'))->get();

    expect(findDate($holidays, 'Friday before AFL Grand Final'))
        ->toEqual(CarbonImmutable::create(2020, 10, 23));
});

it('does not return the day before afl grand final before 2015', function () {
    CarbonImmutable::setTestNow('2014-01-22');

    $holidays = Holidays::for(Australia::make('vic'))->get();

    expect(findDate($holidays, 'Friday before AFL Grand Final'))
        ->toBeNull();
});

it("returns queen's birthday before her death", function () {
    CarbonImmutable::setTestNow('2021-01-22', 'Australia/Perth');

    $holidays = Holidays::for(Australia::make('wa'))->get();

    expect(findDate($holidays, "Queen's Birthday"))
        ->toEqual(CarbonImmutable::create(2021, 9, 27));

    expect(findDate($holidays, "King's Birthday"))
        ->toBeNull();
});

it("returns king's birthday after her death", function () {
    CarbonImmutable::setTestNow('2022-01-22', 'Australia/Perth');

    $holidays = Holidays::for(Australia::make('wa'))->get();

    expect(findDate($holidays, "Queen's Birthday"))
        ->toBeNull();

    expect(findDate($holidays, "King's Birthday"))
        ->toEqual(CarbonImmutable::create(2022, 9, 26));
});

it('can calculate Adelaide Cup Day before 2006', function () {
    CarbonImmutable::setTestNow('2005-01-22', 'Australia/Adelaide');

    $holidays = Holidays::for(Australia::make('sa'))->get();

    expect(findDate($holidays, 'Adelaide Cup Day'))
        ->toEqual(CarbonImmutable::create(2005, 5, 16));
});

it('can calculate Adelaide Cup Day after 2006', function () {
    CarbonImmutable::setTestNow('2007-01-22', 'Australia/Adelaide');

    $holidays = Holidays::for(Australia::make('sa'))->get();

    expect(findDate($holidays, 'Adelaide Cup Day'))
        ->toEqual(CarbonImmutable::create(2007, 3, 12));
});

it('can calculate Reconciliation Day on 27 May', function () {
    CarbonImmutable::setTestNow('2024-01-22', 'Australia/Canberra');

    $holidays = Holidays::for(Australia::make('act'))->get();

    expect(findDate($holidays, 'Reconciliation Day'))
        ->toEqual(CarbonImmutable::create(2024, 5, 27));
});

it('can calculate Reconciliation Day after 27 May', function () {
    CarbonImmutable::setTestNow('2025-01-22', 'Australia/Canberra');

    $holidays = Holidays::for(Australia::make('act'))->get();

    expect(findDate($holidays, 'Reconciliation Day'))
        ->toEqual(CarbonImmutable::create(2025, 6, 2));
});
