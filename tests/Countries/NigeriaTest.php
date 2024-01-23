<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate nigerian holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'ng')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
