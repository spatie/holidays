<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate belgian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'be')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect($holidays)->toMatchSnapshot();
});
