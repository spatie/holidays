<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate latvian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01', 'Europe/Riga');

    $holidays = Holidays::for(country: 'lv')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
