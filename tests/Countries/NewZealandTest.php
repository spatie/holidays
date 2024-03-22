<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('calculates new zealand holidays by date', function (string $name, string $date) {

    $testDate = CarbonImmutable::parse($date);

    $holidayName = Holidays::for('nz')->getName($testDate);
    $isHoliday = Holidays::for('nz')->isHoliday($testDate);

    expect($holidayName)->toBe($name)->and($isHoliday)->toBeTrue();

})->with([
    //2023
    ['New Year\'s Day (Mondayisation)', '2023-01-02'],
    ['Day after New Year\'s Day (Mondayisation)', '2023-01-03'],
    ['Waitangi Day', '2023-02-06'],
    ['Good Friday', '2023-04-07'],
    ['Easter Monday', '2023-04-10'],
    ['ANZAC Day', '2023-04-25'],
    ['King\'s Birthday', '2023-06-05'],
    ['Matariki', '2023-07-14'],
    ['Labour Day', '2023-10-23'],
    ['Christmas Day', '2023-12-25'],
    ['Boxing Day', '2023-12-26'],
    //2024
    ['New Year\'s Day', '2024-01-01'],
    ['Day after New Year\'s Day', '2024-01-02'],
    ['Waitangi Day', '2024-02-06'],
    ['Good Friday', '2024-03-29'],
    ['Easter Monday', '2024-04-01'],
    ['ANZAC Day', '2024-04-25'],
    ['King\'s Birthday', '2024-06-03'],
    ['Matariki', '2024-06-28'],
    ['Labour Day', '2024-10-28'],
    ['Christmas Day', '2024-12-25'],
    ['Boxing Day', '2024-12-26'],
    //2025
    ['New Year\'s Day', '2025-01-01'],
    ['Day after New Year\'s Day', '2025-01-02'],
    ['Waitangi Day', '2025-02-06'],
    ['Good Friday', '2025-04-18'],
    ['Easter Monday', '2025-04-21'],
    ['ANZAC Day', '2025-04-25'],
    ['King\'s Birthday', '2025-06-02'],
    ['Matariki', '2025-06-20'],
    ['Labour Day', '2025-10-27'],
    ['Christmas Day', '2025-12-25'],
    ['Boxing Day', '2025-12-26'],
    //2027 - Lots of Mondayisation
    ['New Year\'s Day', '2027-01-01'],
    ['Day after New Year\'s Day (Mondayisation)', '2027-01-04'],
    ['Waitangi Day (Mondayisation)', '2027-02-08'],
    ['Good Friday', '2027-03-26'],
    ['Easter Monday', '2027-03-29'],
    ['ANZAC Day (Mondayisation)', '2027-04-26'],
    ['King\'s Birthday', '2027-06-07'],
    ['Matariki', '2027-06-25'],
    ['Labour Day', '2027-10-25'],
    ['Christmas Day (Mondayisation)', '2027-12-27'],
    ['Boxing Day (Mondayisation)', '2027-12-28'],
]);

it('calculates new zealand easter holidays by date', function (string $name, string $date) {

    $testDate = CarbonImmutable::parse($date);

    $holidayName = Holidays::for('nz')->getName($testDate);
    $isHoliday = Holidays::for('nz')->isHoliday($testDate);

    expect($holidayName)->toBe($name)->and($isHoliday)->toBeTrue();

})->with([
    ['Good Friday', '2024-03-29'],
    ['Easter Monday', '2024-04-01'],
    ['Good Friday', '2025-04-18'],
    ['Easter Monday', '2025-04-21'],
    ['Good Friday', '2026-04-03'],
    ['Easter Monday', '2026-04-06'],
]);

it('can calculate new zealand holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'nz')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty();
    expect(formatDates($holidays))->toMatchSnapshot();

});

it('returns a substitute day if new years day falls on a weekend', function () {
    CarbonImmutable::setTestNow('2033-01-01');

    $holidays = Holidays::for(country: 'nz')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty();
    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate new zealand holidays if christmas is on a friday', function () {
    CarbonImmutable::setTestNow('2028-01-01');

    $holidays = Holidays::for(country: 'nz')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty();
    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate new zealand holidays if christmas is on a saturday', function () {
    CarbonImmutable::setTestNow('2027-01-01');

    $holidays = Holidays::for(country: 'nz')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty();
    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate new zealand holidays if christmas is on a sunday', function () {
    CarbonImmutable::setTestNow('2022-01-01');

    $holidays = Holidays::for(country: 'nz')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty();
    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate holidays for 2030', function () {
    CarbonImmutable::setTestNow('2030-01-01');

    $holidays = Holidays::for(country: 'nz')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty();
    expect(formatDates($holidays))->toMatchSnapshot();
});
