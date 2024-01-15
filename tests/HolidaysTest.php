<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Exceptions\UnsupportedCountry;
use Spatie\Holidays\Holidays;

it('can get all holidays of the current year', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::all();

    expect($holidays)->toMatchSnapshot();
});

it('can get all holidays of 2023', function () {
    $holidays = Holidays::new()
        ->year(2023)
        ->get();

    expect($holidays)->toMatchSnapshot();
});

it('can get all holidays of 2025', function () {
    $holidays = Holidays::new()
        ->year(2025)
        ->get();

    expect($holidays)->toMatchSnapshot();
});

it('can get all holidays of another year and a specific country', function () {
    $holidays = Holidays::new()
        ->year(2024)
        ->country('BE')
        ->get();

    expect($holidays)->toMatchSnapshot();
});

it('cannot get all holidays of an unknown country code', function () {
    Holidays::new()->country('unknown')->get();
})->throws(UnsupportedCountry::class);

it('cannot get holidays for years before 1970', function () {
    Holidays::new()->year(1969)->get();
})->throws(InvalidYear::class, 'Holidays can only be calculated for years after 1970.');

it('cannot get holidays for years after 2037', function () {
    Holidays::new()->year(2038)->get();
})->throws(InvalidYear::class, 'Holidays can only be calculated for years before 2038');

it('can see if a date is a holiday', function () {
    $result = Holidays::new()->isHoliday('2024-01-01', 'be');
    expect($result)->toBeTrue();

    $result = Holidays::new()->isHoliday('2024-01-02', 'be');
    expect($result)->toBeFalse();
});

it('can see if a date is a holiday when passing Carbon', function () {
    $result = Holidays::new()->isHoliday(CarbonImmutable::parse('2024-01-01'), 'be');
    expect($result)->toBeTrue();

    $result = Holidays::new()->isHoliday(CarbonImmutable::parse('2024-01-02'), 'be');
    expect($result)->toBeFalse();
});

it('can see if a name is a holiday', function () {
    $result = Holidays::new()->isHoliday('2024-01-01', 'be');
    expect($result)->toBeTrue();

    $result = Holidays::new()->isHoliday('2024-01-02', 'be');
    expect($result)->toBeFalse();
});

it('can get the holiday name of a date', function () {
    $result = Holidays::new()->getName(CarbonImmutable::parse('2024-01-01'), 'be');
    expect($result)->toBe('Nieuwjaar');

    $result = Holidays::new()->getName(CarbonImmutable::parse('2024-01-02'), 'be');
    expect($result)->toBeNull();
});
