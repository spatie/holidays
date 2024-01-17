<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate german national holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'de')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();
});

it('can calculate german state-specific holidays', function (string $state) {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'de', state: $state)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->and(formatDates($holidays))
        ->toMatchSnapshot();
})->with([
    'bw',
    'by',
    'nw',
]);

