<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('calculates scottish holidays by date', function (string $name, string $date) {

    $testDate = CarbonImmutable::parse($date);

    $holidayName = Holidays::for('gb-sct')->getName($testDate);
    $isHoliday = Holidays::for('gb-sct')->isHoliday($testDate);

    expect($holidayName)->toBe($name)->and($isHoliday)->toBeTrue();

})->with([
    ['New Year\'s Day', '2024-01-01'],
    ['2nd January', '2024-01-02'],
    ['Good Friday', '2024-03-29'],
    ['Early May bank holiday', '2024-05-06'],
    ['Spring bank holiday', '2024-05-27'],
    ['Summer bank holiday', '2024-08-05'],
    ['St Andrew\'s Day (substitute day)', '2024-12-02'],
    ['Christmas Day', '2024-12-25'],
    ['Boxing Day', '2024-12-26'],
    ['New Year\'s Day', '2025-01-01'],
    ['2nd January', '2025-01-02'],
    ['Good Friday', '2025-04-18'],
    ['Early May bank holiday', '2025-05-05'],
    ['Spring bank holiday', '2025-05-26'],
    ['Summer bank holiday', '2025-08-04'],
    ['St Andrew\'s Day (substitute day)', '2025-12-01'],
    ['Christmas Day', '2025-12-25'],
    ['Boxing Day', '2025-12-26'],
    ['New Year\'s Day', '2026-01-01'],
    ['2nd January', '2026-01-02'],
    ['Good Friday', '2026-04-03'],
    ['Early May bank holiday', '2026-05-04'],
    ['Spring bank holiday', '2026-05-25'],
    ['Summer bank holiday', '2026-08-03'],
    ['St Andrew\'s Day', '2026-11-30'],
    ['Christmas Day', '2026-12-25'],
    ['Boxing Day (substitute day)', '2026-12-28'],
]);

it('can calculate scottish holidays', function () {
    CarbonImmutable::setTestNow('2025-01-01');

    $holidays = Holidays::for(country: 'gb-sct')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();

});

it('returns a substitute day if new years day falls on a weekend', function () {
    CarbonImmutable::setTestNow('2033-01-01');

    $holidays = Holidays::for(country: 'gb-sct')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('returns a substitute day for second of january if new years day falls on a friday', function () {
    CarbonImmutable::setTestNow('2021-01-01');

    $holidays = Holidays::for(country: 'gb-sct')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate scottish holidays if christmas is on a friday', function () {
    CarbonImmutable::setTestNow('2020-01-01');

    $holidays = Holidays::for(country: 'gb-sct')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate scottish holidays if christmas is on a saturday', function () {
    CarbonImmutable::setTestNow('2021-01-01');

    $holidays = Holidays::for(country: 'gb-sct')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate scottish holidays if christmas is on a sunday', function () {
    CarbonImmutable::setTestNow('2022-01-01');

    $holidays = Holidays::for(country: 'gb-sct')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate holidays for 2020', function () {
    CarbonImmutable::setTestNow('2020-01-01');

    $holidays = Holidays::for(country: 'gb-eng')->get();

    expect($holidays)->toBeArray()->not()->toBeEmpty()
        ->and(formatDates($holidays))->toMatchSnapshot();
});
