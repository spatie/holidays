<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it( 'can calculate northern irish holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2025-01-01');

    $holidays = Holidays::for(country: 'uk-nir')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();

});

it('returns a substitute day if new years day falls on a weekend', function () {
    CarbonImmutable::setTestNowAndTimezone('2033-01-01');

    $holidays = Holidays::for(country: 'uk-nir')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('returns a substitute day for second of january if new years day falls on a friday', function () {
    CarbonImmutable::setTestNowAndTimezone('2021-01-01');

    $holidays = Holidays::for(country: 'uk-nir')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate northern irish holidays if christmas is on a friday', function () {
    CarbonImmutable::setTestNowAndTimezone('2020-01-01');

    $holidays = Holidays::for(country: 'uk-nir')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate northern irish holidays if christmas is on a saturday', function () {
    CarbonImmutable::setTestNowAndTimezone('2021-01-01');

    $holidays = Holidays::for(country: 'uk-nir')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate northern irish holidays if christmas is on a sunday', function () {
    CarbonImmutable::setTestNowAndTimezone('2022-01-01');

    $holidays = Holidays::for(country: 'uk-nir')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate northern irish for 2020', function () {
    CarbonImmutable::setTestNowAndTimezone('2020-01-01');

    $holidays = Holidays::for(country: 'uk-cym')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});
