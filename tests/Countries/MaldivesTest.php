<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

foreach ([2000, 2021, 2022, 2023, 2024, 2025] as $year) {
    it("can calculate Maldivian holidays for the year $year", function () use ($year) {
        CarbonImmutable::setTestNowAndTimezone("{$year}-01-01");

        $holidays = Holidays::for(country: 'mv')->get();

        expect($holidays)
            ->toBeArray()
            ->not()->toBeEmpty();

        expect(formatDates($holidays))->toMatchSnapshot();
    });
}
