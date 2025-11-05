<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate honduras holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'hn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
