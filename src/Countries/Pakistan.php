<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Pakistan extends Country
{
    public function countryCode(): string
    {
        return 'pk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Kashmir Solidarity Day' => CarbonImmutable::createFromDate($year, 2, 5),
            'Pakistan Day' => CarbonImmutable::createFromDate($year, 3, 23),
            'Labour Day' => CarbonImmutable::createFromDate($year, 5, 1),
            'Independence Day' => CarbonImmutable::createFromDate($year, 8, 14),
            'Iqbal Day' => CarbonImmutable::createFromDate($year, 11, 9),
            'Quaid-e-Azam Day' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // The variable holidays are all follow lunar calendar so their dates are not confirmed.
        return [];
    }
}
