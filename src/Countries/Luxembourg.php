<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Luxembourg extends Country
{
    public function countryCode(): string
    {
        return 'lu';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Neijoerschdag', "{$year}-01-01"),
            Holiday::national('Dag vun der Aarbecht', "{$year}-05-01"),
            Holiday::national('Europadag', "{$year}-05-09"),
            Holiday::national('Nationalfeierdag', "{$year}-06-23"),
            Holiday::national('Mariä Himmelfahrt', "{$year}-08-15"),
            Holiday::national('Allerhellgen', "{$year}-11-01"),
            Holiday::national('Chrëschtdag', "{$year}-12-25"),
            Holiday::national('Stiefesdag', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Ouschterméindeg', $easter->addDay()),
            Holiday::national('Christi Himmelfahrt', $easter->addDays(39)),
            Holiday::national('Péngschtméindeg', $easter->addDays(50)),
        ];
    }
}
