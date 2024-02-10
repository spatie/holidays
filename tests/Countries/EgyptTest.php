<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Holidays;

it('can calculate egyptian holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'eg')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('cannot calculate egyptian holidays before 2005', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    Holidays::for(country: 'eg', year: 2004)->get();
})->throws(InvalidYear::class);
