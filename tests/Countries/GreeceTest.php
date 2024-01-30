<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate hellenic holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'el')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});
