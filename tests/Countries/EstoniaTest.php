<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate estonian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01', 'Europe/Tallinn');

    $holidays = Holidays::for(country: 'ee')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
