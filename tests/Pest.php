<?php

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

expect()->extend('toContainElement', function (Closure $closure) {
    foreach ($this->value as $element) {
        if ($closure($element)) {
            expect(true)->toBeTrue();

            return;
        }
    }

    test()->fail('Failed asserting that the array contains the expected element.');
});

/** @param array<Holiday> $holidays */
function formatDates(array $holidays): array
{
    return array_map(fn (Holiday $holiday): array => [
        'name' => $holiday->name,
        'date' => $holiday->date->format('Y-m-d'),
    ], $holidays);
}

/** @param array<Holiday> $holidays */
function findDate(array $holidays, string $name): ?CarbonImmutable
{
    foreach ($holidays as $holiday) {
        if ($holiday->name === $name) {
            return $holiday->date;
        }
    }

    return null;
}
