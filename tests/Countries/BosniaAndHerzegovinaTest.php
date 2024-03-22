<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\BosniaAndHerzegovina;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holidays;

it('can calculate bosnia and herzegovina holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'ba')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('throws an error when an invalid region is given', function () {
    new BosniaAndHerzegovina('ba-xy');
})->throws(InvalidRegion::class);

it('can calculate victory day for republic of srpska in bosnia and herzegovina holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $victoryDay = Holidays::for(BosniaAndHerzegovina::make())->isHoliday('2024-01-09');
    expect($victoryDay)->toBeFalse();

    $victoryDayForRepublicOfSprska = Holidays::for(BosniaAndHerzegovina::make('ba-rs'))->isHoliday('2024-01-09');
    expect($victoryDayForRepublicOfSprska)->toBeTrue();
});

it('can translate holidays into english', function () {
    $holidays = Holidays::for(country: 'ba', year: 2024, locale: 'en')->get();

    expect($holidays)
        ->toBeArray()
        ->not()
        ->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

    expect($holidays[0]['name'])->toBe('New Year - first day');
});
