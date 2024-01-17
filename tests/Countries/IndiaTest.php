<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\India;
use Spatie\Holidays\Exceptions\UnsupportedRegion;
use Spatie\Holidays\Holidays;

it('can calculate Indian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'in')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();

    $holidays = Holidays::for(India::make())->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();
});

it('Verify standard holidays in India are identified', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');
    $national = [
        '01-26' => 'Republic Day',
        '05-01' => 'Labour Day',
        '08-15' => 'Independence Day',
        '10-02' => 'Gandhi Jayanti',
        '12-25' => 'Christmas'
    ];

    foreach ($national as $date => $holiday_for) {
        expect(Holidays::for(country: 'in')
            ->isHoliday('2024-' . $date))
            ->toBeTrue();

        expect(Holidays::for(country: 'in')
            ->getName('2024-' . $date))
            ->toBe($holiday_for);
    }
});


it('verify random dates given are not holiday in India', function () {
    $holidays = [
        '01-01' => 'New Year',
        '01-02' => 'Day after New Year',
    ];

    foreach ($holidays as $date => $holiday_for) {
        expect(Holidays::for(country: 'in')
            ->isHoliday('2024-' . $date))
            ->toBeFalse();

        expect(Holidays::for(country: 'in')
            ->getName('2024-' . $date))
            ->toBeNull();
    }
});

it('verify Maharashtra region/state in India has holidays', function () {
    expect(Holidays::for(India::make(), region: 'Maharashtra')->get())
        ->toBeArray()
        ->not()->toBeEmpty();
});

it('verify Maharashtra holiday is not found in other region', function () {
    expect(Holidays::for(India::make(), region: 'Maharashtra')->getName(date: '2024-04-13'))->toBe('Gudi Padwa');
    expect(Holidays::for(India::make(), region: 'Karnataka')->getName(date: '2024-04-13'))->not->toBe('Gudi Padwa');
});

it('verify wrong region throws exception in India', function () {
    expect(Holidays::for(India::make(), region: 'XYZ')->get())->not->toBeArray();
})->throws(UnsupportedRegion::class);
