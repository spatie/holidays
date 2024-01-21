<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate german holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'de')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

});


it('can calculate german historical reformationstag in year 2017', function () {
    CarbonImmutable::setTestNowAndTimezone('2017-01-01');

    $holiday=Holidays::for('de')->isHoliday('2017-10-31');

    expect($holiday)->toBeTrue();

});
it('can calculate german historical reformationstag in year 2018 is not a holiday', function () {
    CarbonImmutable::setTestNowAndTimezone('2018-01-01');

    $holiday=Holidays::for('de')->isHoliday('2018-10-31');

    expect($holiday)->toBeFalse();

});

it('can calculate german buß- und bettag in year 1990', function () {
    CarbonImmutable::setTestNowAndTimezone('1990-01-01');

    $holiday=Holidays::for('de')->isHoliday('1990-10-03');

    expect($holiday)->toBeTrue();

});

