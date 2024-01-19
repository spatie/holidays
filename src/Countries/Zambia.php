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
            'New Year' => '01-01',
            'International Womens Day' => '03-08',
            'Youth Day' => '03-12',
            'Birthday of Kenneth Kaunda' => '04-28',
            'Labour Day' => '05-01',
            'Africa Day' => '05-25',
            'Heroes Day' => '07-01',
            'Unity Day' => '07-02',
            'Farmers Day' => '08-01',
            'National Prayer Day' => '10-18',
            'Independence Day' => '10-24',
            'Christmas Day' => '12-25',

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
