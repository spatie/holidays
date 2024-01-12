<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\HolidaysException;
use Spatie\Holidays\Holidays;

it('can get all holidays of the current year', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::all();

    expect($holidays)->toMatchSnapshot();
});

it('can get all holidays of 2022', function () {
    $holidays = Holidays::new()
        ->year(2022)
        ->get();

    expect($holidays)->toMatchSnapshot();
});

it('can get all holidays of 2023', function () {
    $holidays = Holidays::new()
        ->year(2023)
        ->get();

    expect($holidays)->toMatchSnapshot();
});

it('can get all holidays of 2025', function () {
    $holidays = Holidays::new()
        ->year(2023)
        ->get();

    expect($holidays)->toMatchSnapshot();
});

it('can get all holidays of another year and a specific country', function () {
    $holidays = Holidays::new()
        ->year(2023)
        ->country('BE')
        ->get();

    expect($holidays)->toMatchSnapshot();
});

it('cannot get all holidays of an unknown country code', function () {
    Holidays::new()->country('unknown')->get();
})->throws(HolidaysException::class, 'Country code `unknown` is not supported');

it('cannot get holidays for years before 1970', function () {
    Holidays::new()->year(1969)->get();
})->throws(HolidaysException::class, 'Holidays can only be calculated for years after 1970.');

it('cannot get holidays for years after 2037', function () {
    Holidays::new()->year(2038)->get();
})->throws(HolidaysException::class, 'Holidays can only be calculated for years before 2038');
