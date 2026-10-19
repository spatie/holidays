<?php

namespace Spatie\Holidays\Tests;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Spatie\Holidays\Calendars\ResolvesCalendarDates;
use Spatie\Holidays\Exceptions\InvalidYear;

class TestCalendar
{
    use ResolvesCalendarDates;

    public function countryCode(): string
    {
        return 'test';
    }

    protected function createDate(string $format, string $value): CarbonImmutable
    {
        return CarbonImmutable::createFromFormat($format, $value);
    }
}

it('gets single day holiday for valid year', function () {
    $calendar = new TestCalendar;
    $collection = [
        2024 => '01-01',
        2025 => '01-15',
    ];

    $result = invade($calendar)->getSingleDayHoliday($collection, 2024);

    expect($result->format('Y-m-d'))->toBe('2024-01-01');
});

it('throws for single day holiday with unsupported year', function () {
    $calendar = new TestCalendar;
    $collection = [
        2024 => '01-01',
    ];

    invade($calendar)->getSingleDayHoliday($collection, 2025);
})->throws(InvalidYear::class);

it('throws for empty collection single day holiday', function () {
    $calendar = new TestCalendar;
    $collection = [];

    invade($calendar)->getSingleDayHoliday($collection, 2024);
})->throws(InvalidYear::class);

it('gets multi day holiday for valid year', function () {
    $calendar = new TestCalendar;
    $collection = [
        2024 => '12-25',
    ];

    $result = invade($calendar)->getMultiDayHoliday($collection, 2024, 3);

    expect($result)->toHaveCount(1);
    expect($result[0])->toBeInstanceOf(CarbonPeriod::class);
    expect($result[0]->start->format('Y-m-d'))->toBe('2024-12-25');
    expect($result[0]->end->format('Y-m-d'))->toBe('2024-12-27');
});

it('returns empty array for multi day holiday with unsupported year', function () {
    $calendar = new TestCalendar;
    $collection = [
        2024 => '12-25',
    ];

    $result = invade($calendar)->getMultiDayHoliday($collection, 2025, 3);

    expect($result)->toBeEmpty();
});

it('handles overlapping multi day holiday', function () {
    $calendar = new TestCalendar;
    $collection = [
        2023 => '12-30',
        2024 => '01-01',
    ];

    $result = invade($calendar)->getMultiDayHoliday($collection, 2024, 3);

    expect($result)->toHaveCount(2);
});

it('handles array of dates for multi day holiday', function () {
    $calendar = new TestCalendar;
    $collection = [
        2024 => ['12-25', '12-26'],
    ];

    $result = invade($calendar)->getMultiDayHoliday($collection, 2024, 1);

    expect($result)->toHaveCount(2);
});

it('creates period correctly', function () {
    $calendar = new TestCalendar;

    $result = invade($calendar)->createPeriod('12-25', 2024, 3);

    expect($result)->toBeInstanceOf(CarbonPeriod::class);
    expect($result->start->format('Y-m-d'))->toBe('2024-12-25');
    expect($result->end->format('Y-m-d'))->toBe('2024-12-27');
});

it('detects overlapping dates', function () {
    $calendar = new TestCalendar;
    $collection = [
        2023 => '12-30',
        2024 => '01-01',
    ];

    $result = invade($calendar)->getOverlapping($collection, 2024, 3);

    expect($result)->toBe('12-30');
});

it('returns null for non-overlapping dates', function () {
    $calendar = new TestCalendar;
    $collection = [
        2024 => '01-01',
        2025 => '01-02',
    ];

    $result = invade($calendar)->getOverlapping($collection, 2025, 3);

    expect($result)->toBeNull();
});

it('returns null for overlapping at minimum year', function () {
    $calendar = new TestCalendar;
    $collection = [
        2024 => '12-30',
    ];

    $result = invade($calendar)->getOverlapping($collection, 2024, 3);

    expect($result)->toBeNull();
});
