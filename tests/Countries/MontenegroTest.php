<?php

namespace Spatie\Holidays\Test;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate montenegro holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'me')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
