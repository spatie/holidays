<?php

namespace Spatie\Holidays\Tests;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\HolidayType;

it('can make a holiday with all properties', function () {
    $date = CarbonImmutable::parse('2024-01-01');
    $holiday = Holiday::make('New Year', $date, HolidayType::National, 'BE');

    expect($holiday->name)->toBe('New Year');
    expect($holiday->date)->toBe($date);
    expect($holiday->type)->toBe(HolidayType::National);
    expect($holiday->region)->toBe('BE');
});

it('can make a national holiday', function () {
    $holiday = Holiday::national('New Year', '2024-01-01');

    expect($holiday->name)->toBe('New Year');
    expect($holiday->date->format('Y-m-d'))->toBe('2024-01-01');
    expect($holiday->type)->toBe(HolidayType::National);
    expect($holiday->region)->toBeNull();
});

it('can make a religious holiday', function () {
    $holiday = Holiday::religious('Easter', '2024-03-31');

    expect($holiday->name)->toBe('Easter');
    expect($holiday->date->format('Y-m-d'))->toBe('2024-03-31');
    expect($holiday->type)->toBe(HolidayType::Religious);
    expect($holiday->region)->toBeNull();
});

it('can make an observed holiday', function () {
    $holiday = Holiday::observed('Christmas', '2024-12-25');

    expect($holiday->name)->toBe('Christmas');
    expect($holiday->date->format('Y-m-d'))->toBe('2024-12-25');
    expect($holiday->type)->toBe(HolidayType::Observed);
    expect($holiday->region)->toBeNull();
});

it('can make a regional holiday', function () {
    $holiday = Holiday::regional('Day of Unity', '2024-10-03', 'DE-BW');

    expect($holiday->name)->toBe('Day of Unity');
    expect($holiday->date->format('Y-m-d'))->toBe('2024-10-03');
    expect($holiday->type)->toBe(HolidayType::Regional);
    expect($holiday->region)->toBe('DE-BW');
});

it('can make a regional holiday without region', function () {
    $holiday = Holiday::regional('National Day', '2024-07-14');

    expect($holiday->name)->toBe('National Day');
    expect($holiday->type)->toBe(HolidayType::Regional);
    expect($holiday->region)->toBeNull();
});

it('can make a bank holiday', function () {
    $holiday = Holiday::bank('Bank Holiday', '2024-08-15');

    expect($holiday->name)->toBe('Bank Holiday');
    expect($holiday->date->format('Y-m-d'))->toBe('2024-08-15');
    expect($holiday->type)->toBe(HolidayType::Bank);
    expect($holiday->region)->toBeNull();
});

it('parses string date to carbon', function () {
    $holiday = Holiday::national('New Year', '2024-01-01');

    expect($holiday->date)->toBeInstanceOf(CarbonImmutable::class);
});

it('accepts carbon date directly', function () {
    $date = CarbonImmutable::parse('2024-01-01');
    $holiday = Holiday::national('New Year', $date);

    expect($holiday->date)->toBe($date);
});

it('json serializes correctly', function () {
    $date = CarbonImmutable::parse('2024-01-01');
    $holiday = Holiday::make('New Year', $date, HolidayType::National, 'BE');

    $json = $holiday->jsonSerialize();

    expect($json)->toBe([
        'name' => 'New Year',
        'date' => '2024-01-01',
        'type' => 'national',
        'region' => 'BE',
    ]);
});

it('json serializes with null region', function () {
    $holiday = Holiday::national('New Year', '2024-01-01');

    $json = $holiday->jsonSerialize();

    expect($json['region'])->toBeNull();
});
