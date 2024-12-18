<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate paraguayan holidays', function (): void {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'py')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can get holidays in another locale', function (): void {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'py', locale: 'en')->get();

    expect($holidays[0]['name'])
        ->toBe("New Year's Day");
});

it('can calculate Chacho Armistice holiday', function (int $year, int $valid_day, int $invalid_day): void {
    CarbonImmutable::setTestNow("$year-01-01");

    expect(Holidays::for('py')->isHoliday("$year-06-$valid_day"))->toBeTrue()
     ->and(Holidays::for('py')->isHoliday("$year-06-$invalid_day"))->toBeFalse();
})->with([
    [2012, 12, 16],
    [2013, 12, 16],
    [2014, 16, 12],
    [2015, 12, 16],
    [2016, 12, 16],
    [2024, 12, 16],
]);
