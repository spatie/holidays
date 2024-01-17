<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate australian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01', 'Australia/Melbourne');

    $holidays = Holidays::for(country: 'au')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
