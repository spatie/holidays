<?php

namespace Spatie\Holidays\Tests\Countries;

use Spatie\Holidays\Exceptions\InvalidCountry;
use Spatie\Holidays\Holidays;

it('cannot calculate sri lanka holidays', function () {
    Holidays::for(country: 'lk')->get();
})->throws(InvalidCountry::class);
