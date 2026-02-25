<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Zambia extends Country
{
    public function countryCode(): string
    {
        return 'zm';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year' => CarbonImmutable::createFromDate($year, 1, 1),
            'International Womens Day' => CarbonImmutable::createFromDate($year, 3, 8),
            'Youth Day' => CarbonImmutable::createFromDate($year, 3, 12),
            'Birthday of Kenneth Kaunda' => CarbonImmutable::createFromDate($year, 4, 28),
            'Labour Day' => CarbonImmutable::createFromDate($year, 5, 1),
            'Africa Day' => CarbonImmutable::createFromDate($year, 5, 25),
            'Heroes Day' => CarbonImmutable::createFromDate($year, 7, 1),
            'Unity Day' => CarbonImmutable::createFromDate($year, 7, 2),
            'Farmers Day' => CarbonImmutable::createFromDate($year, 8, 1),
            'National Prayer Day' => CarbonImmutable::createFromDate($year, 10, 18),
            'Independence Day' => CarbonImmutable::createFromDate($year, 10, 24),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),

        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
        ];
    }
}
