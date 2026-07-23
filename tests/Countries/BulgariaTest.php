<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate bulgarian holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'bg')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate bulgarian holidays in english', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'bg', locale: 'en')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('adds a single substitute day when only one holiday in a cluster falls on a weekend', function () {
    // 2017: 24 Dec (Sun), 25 Dec (Mon), 26 Dec (Tue) -> only the 24th needs compensating.
    CarbonImmutable::setTestNow('2017-01-01');

    $holidays = Holidays::for(country: 'bg')->get();
    $byDate = [];
    foreach (formatDates($holidays) as $h) {
        $byDate[$h['date']] = $h['name'];
    }

    expect($byDate)->toHaveKey('2017-12-27');
    expect($byDate['2017-12-27'])->toContain('неприсъствен ден');
    expect($byDate)->not()->toHaveKey('2017-12-28');
});

it('adds two substitute days when a friday-saturday-sunday cluster loses two weekdays', function () {
    // 2021: 24 Dec (Fri), 25 Dec (Sat), 26 Dec (Sun) -> the 25th and 26th each need compensating.
    CarbonImmutable::setTestNow('2021-01-01');

    $holidays = Holidays::for(country: 'bg')->get();
    $byDate = [];
    foreach (formatDates($holidays) as $h) {
        $byDate[$h['date']] = $h['name'];
    }

    expect($byDate)->toHaveKey('2021-12-27');
    expect($byDate)->toHaveKey('2021-12-28');
    expect($byDate['2021-12-27'])->toContain('неприсъствен ден');
    expect($byDate['2021-12-28'])->toContain('неприсъствен ден');
});

it('cascades substitute days past an already-observed monday holiday', function () {
    // 2022: 24 Dec (Sat), 25 Dec (Sun), 26 Dec (Mon) -> the 24th and 25th each need
    // compensating, but the 26th is already its own holiday, so both substitutes
    // land on the 27th and 28th instead of colliding with the 26th.
    CarbonImmutable::setTestNow('2022-01-01');

    $holidays = Holidays::for(country: 'bg')->get();
    $byDate = [];
    foreach (formatDates($holidays) as $h) {
        $byDate[$h['date']] = $h['name'];
    }

    expect($byDate)->toHaveKey('2022-12-27');
    expect($byDate)->toHaveKey('2022-12-28');
    expect($byDate['2022-12-27'])->toContain('неприсъствен ден');
    expect($byDate['2022-12-28'])->toContain('неприсъствен ден');
});

it('adds substitute days for isolated fixed holidays falling on a sunday', function () {
    // 2024: 3 March and 22 September both fall on a Sunday.
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'bg')->get();
    $byDate = [];
    foreach (formatDates($holidays) as $h) {
        $byDate[$h['date']] = $h['name'];
    }

    expect($byDate)->toHaveKey('2024-03-04');
    expect($byDate['2024-03-04'])->toContain('неприсъствен ден');
    expect($byDate)->toHaveKey('2024-09-23');
    expect($byDate['2024-09-23'])->toContain('неприсъствен ден');
});

it('does not add substitute days for the easter cluster', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'bg')->get();

    foreach ($holidays as $holiday) {
        expect($holiday->name)->not()->toContain('Великден (неприсъствен ден)');
        expect($holiday->name)->not()->toContain('петък (неприсъствен ден)');
        expect($holiday->name)->not()->toContain('събота (неприсъствен ден)');
    }
});
