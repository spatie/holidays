<?php

expect()->extend('toContainElement', function (Closure $closure) {
    foreach ($this->value as $actualSubarray) {
        if ($closure($actualSubarray)) {
            expect(true)->toBeTrue();

            return;
        }
    }

    test()->fail('Failed asserting that the array contains the expected subarray.');
});

function formatDates(array $holidays): array
{
    foreach ($holidays as &$holiday) {
        $holiday['date'] = $holiday['date']->format('Y-m-d');
    }

    return $holidays;
}

function findDate(array $holidays, string $name): ?Carbon\CarbonImmutable
{
    foreach ($holidays as $holiday) {
        if ($holiday['name'] === $name) {
            return $holiday['date'];
        }
    }

    return null;
}
