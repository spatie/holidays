<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate lithuanian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01', 'Europe/Vilnius');

    $holidays = Holidays::for(country: 'lt')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
