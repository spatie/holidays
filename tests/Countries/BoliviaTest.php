<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate bolivian holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'bo')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();

});
