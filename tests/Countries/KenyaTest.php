<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate kenyan holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'ke')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('calculates October 10th holiday as Mazingira Day in 2024', function () {
    CarbonImmutable::setTestNow('2024-10-10');

    $holidays = Holidays::for(country: 'ke')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(findDate($holidays, 'Mazingira Day'))
        ->toEqual(CarbonImmutable::create(2024, 10, 10));

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('calculates October 10th holiday as Utamaduni Day in 2023', function () {
    CarbonImmutable::setTestNow('2023-10-10');

    $holidays = Holidays::for(country: 'ke')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(findDate($holidays, 'Utamaduni Day'))
        ->toEqual(CarbonImmutable::create(2023, 10, 10));

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('calculates October 10th holiday as Huduma Day in 2021', function () {
    CarbonImmutable::setTestNow('2021-10-10');

    $holidays = Holidays::for(country: 'ke')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(findDate($holidays, 'Huduma Day'))
        ->toEqual(CarbonImmutable::create(2021, 10, 10));

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('calculates October 10th holiday as Moi Day before 2019', function () {
    CarbonImmutable::setTestNow('2018-10-10');

    $holidays = Holidays::for(country: 'ke')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(findDate($holidays, 'Moi Day'))
        ->toEqual(CarbonImmutable::create(2018, 10, 10));

    expect(formatDates($holidays))->toMatchSnapshot();
});
