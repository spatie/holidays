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
            'Kashmir Solidarity Day' => '02-05',
            'Pakistan Day' => '03-23',
            'Labour Day' => '05-01',
            'Independence Day' => '08-14',
            'Iqbal Day' => '11-09',
            'Quaid-e-Azam Day' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // The variable holidays are all follow lunar calendar so their dates are not confirmed.
        return [];
    }
}
