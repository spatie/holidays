<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Malaysia;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holidays;

it('can calculate Malaysia holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'my')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate Hari Raya is in year 2023', function () {
    CarbonImmutable::setTestNow('2023-01-01');

    $holiday = Holidays::for('my')->isHoliday('2023-04-22');

    expect($holiday)->toBeTrue();
});

it('can calculate Tahun Baru Cina in year 2023', function () {
    CarbonImmutable::setTestNow('2023-01-01');

    $holiday = Holidays::for('my')->isHoliday('2023-01-22');

    expect($holiday)->toBeTrue();
});

it('cannot calculate invalid region', function () {
    $holiday = Holidays::for(Malaysia::make('invalid-region'))->get();
})->throws(InvalidRegion::class);
