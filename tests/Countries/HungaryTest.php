<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate hungarian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'hu')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect($holidays[0]['name'])->toBe('Újév');
    expect($holidays[0]['date']->format('Y-m-d'))->toBe('2024-01-01');
});
