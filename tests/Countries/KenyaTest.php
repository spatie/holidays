<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Kenya;
use Spatie\Holidays\Holidays;

it('can calculate kenyan holidays 2024', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-10-10');
    $holidays = Holidays::for(Kenya::make())->get();
    expect($holidays)->toBeArray()->not()->toBeEmpty();
    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate kenyan holidays 2026', function () {
    CarbonImmutable::setTestNowAndTimezone('2026-06-01');
    $holidays = Holidays::for(Kenya::make())->get();
    expect($holidays)->toBeArray()->not()->toBeEmpty();
    expect(formatDates($holidays))->toMatchSnapshot();
});
