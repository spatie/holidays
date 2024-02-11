<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate syria holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'sy')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});
it('can translate syria holidays into arabic', function () {
    $holidays = Holidays::for(country: 'sy', year: 2024, locale: 'ar')->get();
    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
