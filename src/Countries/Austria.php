<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Austria extends Country
{
    public function countryCode(): string
    {
        return 'at';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Neujahr', "{$year}-01-01"),
            Holiday::national('Heilige Drei Könige', "{$year}-01-06"),
            Holiday::national('Staatsfeiertag', "{$year}-05-01"),
            Holiday::national('Mariä Himmelfahrt', "{$year}-08-15"),
            Holiday::national('Nationalfeiertag', "{$year}-10-26"),
            Holiday::national('Allerheiligen', "{$year}-11-01"),
            Holiday::national('Mariä Empfängnis', "{$year}-12-08"),
            Holiday::national('Christtag', "{$year}-12-25"),
            Holiday::national('Stefanitag', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Ostermontag', $easter->addDay()),
            Holiday::national('Christi Himmelfahrt', $easter->addDays(39)),
            Holiday::national('Pfingstmontag', $easter->addDays(50)),
            Holiday::national('Fronleichnam', $easter->addDays(60)),
        ];
    }
}
