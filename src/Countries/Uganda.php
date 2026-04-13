<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Uganda extends Country
{
    public function countryCode(): string
    {
        return 'ug';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's  Day", "{$year}-01-01"),
            Holiday::national('NRM Liberation Day', "{$year}-01-26"),
            Holiday::national('Archbishop Janani Luwum Day', "{$year}-02-16"),
            Holiday::national("International Women's Day", "{$year}-03-08"),
            Holiday::national('Labour Day', "{$year}-05-01"),
            Holiday::national("Martyrs' Day", "{$year}-06-03"),
            Holiday::national('National Hereos Day', "{$year}-06-09"),
            Holiday::national('Independence Day', "{$year}-10-09"),
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
