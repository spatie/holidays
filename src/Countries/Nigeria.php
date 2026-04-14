<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Nigeria extends Country
{
    public function countryCode(): string
    {
        return 'ng';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national("Worker's Day", "{$year}-05-01"),
            Holiday::national('Democracy Day', "{$year}-06-12"),
            Holiday::national('Independence Day', "{$year}-10-01"),
            Holiday::national('Christmas Day', "{$year}-12-25"),
            Holiday::national('Boxing Day', "{$year}-12-26"),
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
