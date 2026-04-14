<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate united states holidays after 2021', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'us')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});

it('can calculate united states holidays before 2021', function () {
    CarbonImmutable::setTestNow('2020-01-01');

    $holidays = Holidays::for(country: 'us')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});

it('observes saturday holidays on preceding friday', function () {
    CarbonImmutable::setTestNow('2026-01-01');

    $holidays = Holidays::for(country: 'us')->get();
    $formattedHolidays = formatDates($holidays);
    $byName = [];
    foreach ($formattedHolidays as $h) {
        $byName[$h['name']] = $h['date'];
    }

    expect($byName['Independence Day'])->toBe('2026-07-03');
});

it('observes sunday holidays on following monday', function () {
    CarbonImmutable::setTestNow('2027-01-01');

    $holidays = Holidays::for(country: 'us')->get();
    $formattedHolidays = formatDates($holidays);
    $byName = [];
    foreach ($formattedHolidays as $h) {
        $byName[$h['name']] = $h['date'];
    }

    expect($byName['Independence Day'])->toBe('2027-07-05');
    expect($byName['Juneteenth National Independence Day'])->toBe('2027-06-18');
    expect($byName['Christmas'])->toBe('2027-12-24');
});
