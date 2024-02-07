<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate albanian holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'al')->get();
    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can get holidays in another locale', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'al', locale: 'en')->get();

    expect($holidays[0]['name'])
        ->toBe("New Year's Day");
});

it('does not return a holiday falsely', function () {
    $dateInstance = CarbonImmutable::createFromDate('2024-01-03');
    $holiday = Holidays::for(country: 'al');

    $isHoliday = $holiday->isHoliday($dateInstance);
    expect($isHoliday)->toBeFalse();

    $holidayName = $holiday->getName($dateInstance);
    expect($holidayName)->toBeNull();
});

describe('national holidays with standard dates', function () {
    $holiday = Holidays::for(country: 'al');

    it('can calculate the `Viti i Ri` holiday as expected', function () use ($holiday) {
        $dateInstance = CarbonImmutable::createFromDate('2024-01-01');

        $isHoliday = $holiday->isHoliday($dateInstance);
        expect($isHoliday)->toBeTrue();

        $holidayName = $holiday->getName($dateInstance);
        expect($holidayName)->toBe('Viti i Ri');
    });

    it('can calculate the `Dita e Verës` holiday as expected', function () use ($holiday) {
        $dateInstance = CarbonImmutable::createFromDate('2024-03-14');

        $isHoliday = $holiday->isHoliday($dateInstance);
        expect($isHoliday)->toBeTrue();

        $holidayName = $holiday->getName($dateInstance);
        expect($holidayName)->toBe('Dita e Verës');
    });

    it('can calculate the `Dita e Sulltan Nevruzit` holiday as expected', function () use ($holiday) {
        $dateInstance = CarbonImmutable::createFromDate('2024-03-22');

        $isHoliday = $holiday->isHoliday($dateInstance);
        expect($isHoliday)->toBeTrue();

        $holidayName = $holiday->getName($dateInstance);
        expect($holidayName)->toBe('Dita e Sulltan Nevruzit');
    });

    it('can calculate the `Dita Ndërkombëtare e Punëtorëve` holiday as expected', function () use ($holiday) {
        $dateInstance = CarbonImmutable::createFromDate('2024-05-01');

        $isHoliday = $holiday->isHoliday($dateInstance);
        expect($isHoliday)->toBeTrue();

        $holidayName = $holiday->getName($dateInstance);
        expect($holidayName)->toBe('Dita Ndërkombëtare e Punëtorëve');
    });

    it('can calculate the `Dita e Shenjtërimit të Shenjt Terezës` holiday as expected', function () use ($holiday) {
        $dateInstance = CarbonImmutable::createFromDate('2024-09-05');

        $isHoliday = $holiday->isHoliday($dateInstance);
        expect($isHoliday)->toBeTrue();

        $holidayName = $holiday->getName($dateInstance);
        expect($holidayName)->toBe('Dita e Shenjtërimit të Shenjt Terezës');
    });

    it('can calculate the `Dita e Pavarësisë` holiday as expected', function () use ($holiday) {
        $dateInstance = CarbonImmutable::createFromDate('2024-11-28');

        $isHoliday = $holiday->isHoliday($dateInstance);
        expect($isHoliday)->toBeTrue();

        $holidayName = $holiday->getName($dateInstance);
        expect($holidayName)->toBe('Dita e Pavarësisë');
    });

    it('can calculate the `Dita e Çlirimit` holiday as expected', function () use ($holiday) {
        $dateInstance = CarbonImmutable::createFromDate('2024-11-29');

        $isHoliday = $holiday->isHoliday($dateInstance);
        expect($isHoliday)->toBeTrue();

        $holidayName = $holiday->getName($dateInstance);
        expect($holidayName)->toBe('Dita e Çlirimit');
    });

    it('can calculate the `Dita Kombëtare e Rinisë` holiday as expected', function () use ($holiday) {
        $dateInstance = CarbonImmutable::createFromDate('2024-12-08');

        $isHoliday = $holiday->isHoliday($dateInstance);
        expect($isHoliday)->toBeTrue();

        $holidayName = $holiday->getName($dateInstance);
        expect($holidayName)->toBe('Dita Kombëtare e Rinisë');
    });

    it('can calculate the `Krishtlindja` holiday as expected', function () use ($holiday) {
        $dateInstance = CarbonImmutable::createFromDate('2024-12-25');

        $isHoliday = $holiday->isHoliday($dateInstance);
        expect($isHoliday)->toBeTrue();

        $holidayName = $holiday->getName($dateInstance);
        expect($holidayName)->toBe('Krishtlindja');
    });
});
