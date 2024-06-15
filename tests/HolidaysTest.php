<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Belgium;
use Spatie\Holidays\Countries\Netherlands;
use Spatie\Holidays\Exceptions\InvalidCountry;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Holidays;

it('can get all holidays of the current year', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(Belgium::make())->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect($holidays[0]['name'])->toBe('Nieuwjaar');
    expect($holidays[0]['date']->format('Y-m-d'))->toBe('2024-01-01');
});

it('can get holidays of other years', function (string $year) {
    $holidays = Holidays::for(Belgium::make(), year: $year)->get();

    expect($holidays[0]['name'])->toBe('Nieuwjaar');
    expect($holidays[0]['date']->format('Y-m-d'))->toBe("{$year}-01-01");
})->with(
    ['2023'],
    ['2024'],
    ['2025'],
);

it('can get all holidays of another year and a specific country', function () {
    $holidays = Holidays::for(Netherlands::make(), year: 2020)->get();

    expect($holidays)->toContainElement(function (array $holidayProperties) {
        return $holidayProperties['name'] === 'Bevrijdingsdag'
            && $holidayProperties['date']->format('Y-m-d') === '2020-05-05';
    });
});

it('cannot get all holidays of an unknown country code', function () {
    Holidays::for(country: 'unknown');
})->throws(InvalidCountry::class);

it('cannot get holidays for years before 1970', function () {
    Holidays::for(country: 'be', year: 1969)->get();
})->throws(InvalidYear::class, 'Holidays can only be calculated for years after 1970.');

it('cannot get holidays for years after 2037', function () {
    Holidays::for(country: 'be', year: 2038)->get();
})->throws(InvalidYear::class, 'Holidays can only be calculated for years before 2038');

it('can see if a date is a holiday', function () {
    $result = Holidays::for(Belgium::make())->isHoliday('2024-01-01');
    expect($result)->toBeTrue();

    $result = Holidays::for(Belgium::make())->isHoliday('2024-01-02');
    expect($result)->toBeFalse();
});

it('can see if a date is a holiday when passing Carbon', function () {
    $result = Holidays::for(Belgium::make())->isHoliday(CarbonImmutable::parse('2024-01-01'));
    expect($result)->toBeTrue();

    $result = Holidays::for(Belgium::make())->isHoliday(CarbonImmutable::parse('2024-01-02'));
    expect($result)->toBeFalse();
});

it('can see if a name is a holiday', function () {
    $result = Holidays::for('be')->isHoliday('2024-01-01');
    expect($result)->toBeTrue();

    $result = Holidays::for('be')->isHoliday('2024-01-02');
    expect($result)->toBeFalse();
});

it('can get the holiday name of a date', function () {
    $result = Holidays::for('be')->getName(CarbonImmutable::parse('2024-01-01'));
    expect($result)->toBe('Nieuwjaar');

    $result = Holidays::for('be')->getName(CarbonImmutable::parse('2024-01-02'));
    expect($result)->toBeNull();
});

it('can get the country is supported', function () {
    $result = Holidays::has(country: 'be');
    expect($result)->toBeTrue();

    $result = Holidays::has(country: 'unknown');
    expect($result)->toBeFalse();
});

it('can get translated holiday names', function () {
    $result = Holidays::for(country: 'be', year: 2020, locale: 'fr')->get();

    expect($result)->toBeArray();
    expect($result[0]['name'])->toBe('Jour de l\'An');
});

it('default when the locale file is missing', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    // so we don't need to have a translation file for the language in the Country class
    $holidays = Holidays::for(country: 'be', locale: 'en')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect($holidays[0]['name'])->toBe('Nieuwjaar');
    expect($holidays[0]['date']->format('Y-m-d'))->toBe('2024-01-01');
});
