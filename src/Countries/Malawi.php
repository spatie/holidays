<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Malawi extends Country
{
    public function countryCode(): string
    {
        return 'mw';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('New Years  Day', "{$year}-01-01"),
            Holiday::national('John Chilembwe Day', "{$year}-01-15"),
            Holiday::national('Martyrs Day', "{$year}-03-03"),
            Holiday::national('Labour Day', "{$year}-05-01"),
            Holiday::national('Kamuzu Day', "{$year}-05-14"),
            Holiday::national('Independence Day', "{$year}-07-06"),
            Holiday::national('Mothers Day', "{$year}-10-15"),
            Holiday::national('Christmas Day', "{$year}-12-25"),
            Holiday::national('Boxing Day', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    private function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('Easter Monday', $easter->addDay()),
        ];
    }
}
