<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate egypt holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'eg')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});
