<?php

use Spatie\Holidays\Holidays;

it('can get all holidays of the current year', function () {
    $holidays = Holidays::get();
});

it('can get all holidays of another year', function () {
    $holidays = Holidays::forYear(2022)->get();
});

it('cannot get all holidays of an unknown country code', function () {
    $holidays = Holidays::forCountry('unknown')->get();
});
