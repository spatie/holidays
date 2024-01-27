<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate irish holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'ie')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate St Bridid\'s day in Ireland', function () {
    // In 2022, there was no St Brigid's Day
    expect(Holidays::for(country: 'ie')->isHoliday('2022-02-07'))->toBe(false);

    // In 2023, it was on Monday 6th Feb
    expect(Holidays::for(country: 'ie')->isHoliday('2023-02-06'))->toBe(true);

    // In 2030, it will fall on Friday 1st Feb
    expect(Holidays::for(country: 'ie')->isHoliday('2030-02-01'))->toBe(true);
});
