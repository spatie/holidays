<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Pakistan extends Country
{
    public function countryCode(): string
    {
        return 'pk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Kashmir Solidarity Day', "{$year}-02-05"),
            Holiday::national('Pakistan Day', "{$year}-03-23"),
            Holiday::national('Labour Day', "{$year}-05-01"),
            Holiday::national('Independence Day', "{$year}-08-14"),
            Holiday::national('Iqbal Day', "{$year}-11-09"),
            Holiday::national('Quaid-e-Azam Day', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        return [];
    }
}
