<?php

use Spatie\Holidays\Holidays;
use Spatie\Holidays\Exceptions\HolidaysException;

it('can get all holidays of the current year', function () {
    $holidays = Holidays::all();

    expect($holidays)->toMatchSnapshot();
});

it('can get all holidays of another year', function () {
    $holidays = Holidays::new()
        ->year(2022)
        ->get();

    expect($holidays)->toMatchSnapshot();
});

it('can get all holidays of another year and a specific country', function () {
    $holidays = Holidays::new()
        ->year(2022)
        ->country('BE')
        ->get();

    expect($holidays)->toMatchSnapshot();
});

it('cannot get all holidays of an unknown country code', function () {
    dd(Holidays::new()->country('unknown')->get());
})->throws(HolidaysException::class, 'Country code `unknown` is not supported');

it('cannot get holidays for years before 1970', function () {
    Holidays::new()->year(1969)->get();
})->throws(HolidaysException::class, 'Holidays can only be calculated for years after 1970.');

it('cannot get holidays for years after 2037', function () {
    Holidays::new()->year(2038)->get();
})->throws(HolidaysException::class, 'Holidays can only be calculated for years before 2038');
