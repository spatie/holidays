<?php

namespace Spatie\Holidays\Tests\Countries;

use Spatie\Holidays\Holidays;

it('can calculate malaysian holidays', function () {
    $holidays = Holidays::for(country: 'ms')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
