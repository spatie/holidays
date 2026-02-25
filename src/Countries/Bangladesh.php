<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Bangladesh extends Country
{
    public function countryCode(): string
    {
        return 'bd';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'International Mother Language Day' => CarbonImmutable::createFromDate($year, 2, 21),
            'Birthday of Sheikh Mujibur Rahman' => CarbonImmutable::createFromDate($year, 3, 17),
            'Independence Day' => CarbonImmutable::createFromDate($year, 3, 26),
            'Bengali New Year' => CarbonImmutable::createFromDate($year, 4, 14),
            'May Day' => CarbonImmutable::createFromDate($year, 5, 1),
            'National Mourning Day' => CarbonImmutable::createFromDate($year, 8, 15),
            'Victory Day' => CarbonImmutable::createFromDate($year, 12, 16),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // The variable holidays all follow the lunar calendar, so their dates are not confirmed.
        return [];
    }
}
