<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Switzerland;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holidays;

it('can calculate swiss holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'ch')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can get swiss holidays for a specified region (zh)', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $switzerland = new Switzerland(region: 'ch-zh');

    $holidays = Holidays::for($switzerland)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('throws an error when an invalid region is given', function () {
    new Switzerland('ch-xx');
})->throws(InvalidRegion::class);

it('can translate swiss holidays into french', function () {
    $holidays = Holidays::for(country: 'ch', locale: 'fr', year: 2024)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can translate swiss holidays into italian', function () {
    $holidays = Holidays::for(country: 'ch', locale: 'it', year: 2024)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
