<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it( 'can calculate welsh holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'cy')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();

});

it('returns a substitute day if new years day falls on a weekend', function () {
    CarbonImmutable::setTestNowAndTimezone('2033-01-01');

    $holidays = Holidays::for(country: 'cy')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});


it('returns a substitute day if boxing day falls on a weekend', function () {
    CarbonImmutable::setTestNowAndTimezone('2026-01-01');

    $holidays = Holidays::for(country: 'cy')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('returns a substitute day if christmas day falls on a weekend', function () {
    CarbonImmutable::setTestNowAndTimezone('2027-01-01');

    $holidays = Holidays::for(country: 'cy')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});