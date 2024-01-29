<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Germany;
use Spatie\Holidays\Holidays;

it('can calculate german holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'de')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});
it('can calculate german historical unity day in year 1990', function () {
    CarbonImmutable::setTestNow('1990-01-01');

    $holiday = Holidays::for('de')->isHoliday('1990-06-17');

    expect($holiday)->toBeTrue();

});
it('can calculate german unity day in year 1990', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holiday = Holidays::for('de')->isHoliday('2024-10-03');

    expect($holiday)->toBeTrue();

});
it('can calculate german historical reformationstag in year 2017', function () {
    CarbonImmutable::setTestNow('2017-01-01');

    $holiday = Holidays::for('de')->isHoliday('2017-10-31');

    expect($holiday)->toBeTrue();

});
it('can calculate german historical reformationstag in year 2018 is not a holiday', function () {
    CarbonImmutable::setTestNow('2018-01-01');

    $holiday = Holidays::for('de')->isHoliday('2018-10-31');

    expect($holiday)->toBeFalse();

});

it('can calculate german buß- und bettag in year 1990', function () {
    CarbonImmutable::setTestNow('1990-01-01');

    $holiday = Holidays::for('de')->isHoliday('1990-11-21');

    expect($holiday)->toBeTrue();

});
it('can calculate german berlin holiday Victory in Europe Day in year 2020', function () {
    CarbonImmutable::setTestNow('2020-01-01');

    $holiday = Holidays::for(Germany::make('DE-BE'))->isHoliday('2020-05-08');

    expect($holiday)->toBeTrue();

});
/*
 This test will check for all regional holidays in Germany. Source: https://en.wikipedia.org/wiki/Public_holidays_in_Germany
    The total numbers are referenced in the wikipedia article.
*/
it('can get german holidays for other regions', function (string $region, int $totalHolidays) {
    CarbonImmutable::setTestNow('2024-01-01');
    $holidays = Holidays::for(Germany::make('DE-'.$region))->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(count($holidays))->toBe($totalHolidays);

    expect(formatDates($holidays))->toMatchSnapshot();
})->with(
    [
        ['BW', 12],
        ['BY', 13],
        ['BE', 10],
        ['BB', 12],
        ['HB', 10],
        ['HH', 10],
        ['HE', 12],
        ['MV', 11],
        ['NI', 10],
        ['NW', 11],
        ['RP', 11],
        ['SL', 12],
        ['SN', 11],
        ['ST', 11],
        ['SH', 10],
        ['TH', 11]]
);

it('can calculate german holidays in local', function (string $locale, string $newYearsDayName) {
    CarbonImmutable::setTestNow('2024-01-01');
    $result = Holidays::for(country: 'de', year: 2024, locale: $locale)->get();

    expect($result)->toBeArray();
    expect($result[0]['name'])->toBe($newYearsDayName);
})->with(
    [
        ['en', 'New Year'],
        ['nl', 'Nieuwjaar'],
        ['fr', 'Jour de l\'An'],
    ]
);
