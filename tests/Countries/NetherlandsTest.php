<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate dutch holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'nl')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect($holidays[0]['name'])->toBe('Nieuwjaar');
    expect($holidays[0]['date']->format('Y-m-d'))->toBe('2024-01-01');
});
