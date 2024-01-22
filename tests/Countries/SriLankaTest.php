<?php

namespace Spatie\Holidays\Tests\Countries;

use Spatie\Holidays\Exceptions\UnsupportedCountry;
use Spatie\Holidays\Holidays;

it('cannot calculate sri lanka holidays', function () {
    Holidays::for(country: 'lk')->get();
})->throws(UnsupportedCountry::class);
