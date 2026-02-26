<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Bangladesh extends Country
{
    public function countryCode(): string
    {
        return 'bd';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('International Mother Language Day', "{$year}-02-21"),
            Holiday::national('Birthday of Sheikh Mujibur Rahman', "{$year}-03-17"),
            Holiday::national('Independence Day', "{$year}-03-26"),
            Holiday::national('Bengali New Year', "{$year}-04-14"),
            Holiday::national('May Day', "{$year}-05-01"),
            Holiday::national('National Mourning Day', "{$year}-08-15"),
            Holiday::national('Victory Day', "{$year}-12-16"),
            Holiday::national('Christmas Day', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        return [];
    }
}
