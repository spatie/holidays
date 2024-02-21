<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate iran holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'ir')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate iran holidays in local', function (string $locale, string $newYearsDayName) {
    CarbonImmutable::setTestNow('2024-01-01');
    $result = Holidays::for(country: 'ir', locale: $locale)->get();

    expect($result)->toBeArray();
    expect($result[7]['name'])->toBe($newYearsDayName);
})->with(
    [
        ['en', 'Sizdah Bedar'],
        ['fa', 'سیزده بدر'],
    ]
);
