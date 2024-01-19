<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Vietnam;
use Spatie\Holidays\Holidays;

it('can calculate vietnamese holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01', 'Asia/Ho_Chi_Minh');

    $holidays = Holidays::for(country: 'vi')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
