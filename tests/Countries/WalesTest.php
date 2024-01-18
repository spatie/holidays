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


it('can calculate welsh holidays if christmas is on a friday', function () {
    CarbonImmutable::setTestNowAndTimezone('2020-01-01');

    $holidays = Holidays::for(country: 'cy')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate welsh holidays if christmas is on a saturday', function () {
    CarbonImmutable::setTestNowAndTimezone('2021-01-01');

    $holidays = Holidays::for(country: 'cy')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate welsh holidays if christmas is on a sunday', function () {
    CarbonImmutable::setTestNowAndTimezone('2022-01-01');

    $holidays = Holidays::for(country: 'cy')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});