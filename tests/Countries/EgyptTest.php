<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate egyptian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01', 'Africa/Cairo');

    $holidays = Holidays::for(country: 'eg')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
