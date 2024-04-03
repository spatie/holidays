<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate tunisia holidays', function ($year) {
    CarbonImmutable::setTestNow($year.'-01-01');

    $holidays = Holidays::for(country: 'tn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
})->with([2024, 2025]);
