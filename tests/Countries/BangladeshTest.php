<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate bangladeshi holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'bd')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
