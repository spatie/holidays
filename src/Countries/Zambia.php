<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Zambia extends Country
{
    public function countryCode(): string
    {
        return 'zm';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('New Year', "{$year}-01-01"),
            Holiday::national('International Womens Day', "{$year}-03-08"),
            Holiday::national('Youth Day', "{$year}-03-12"),
            Holiday::national('Birthday of Kenneth Kaunda', "{$year}-04-28"),
            Holiday::national('Labour Day', "{$year}-05-01"),
            Holiday::national('Africa Day', "{$year}-05-25"),
            Holiday::national('Heroes Day', "{$year}-07-01"),
            Holiday::national('Unity Day', "{$year}-07-02"),
            Holiday::national('Farmers Day', "{$year}-08-01"),
            Holiday::national('National Prayer Day', "{$year}-10-18"),
            Holiday::national('Independence Day', "{$year}-10-24"),
            Holiday::national('Christmas Day', "{$year}-12-25"),

        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('Easter Monday', $easter->addDay()),
        ];
    }
}
