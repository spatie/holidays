<?php

namespace Spatie\Holidays\Tests\Countries;

use Spatie\Holidays\Holidays;

it('can calculate maldives holidays', function () {
    $holidays = Holidays::for(country: 'mv')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
