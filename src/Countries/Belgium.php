<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Belgium extends Country
{
    public function countryCode(): string
    {
        return 'be';
    }

    protected function defaultLocale(): string
    {
        return 'nl';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Nieuwjaar', "{$year}-01-01"),
            Holiday::national('Dag van de Arbeid', "{$year}-05-01"),
            Holiday::national('Nationale Feestdag', "{$year}-07-21"),
            Holiday::national('OLV Hemelvaart', "{$year}-08-15"),
            Holiday::national('Allerheiligen', "{$year}-11-01"),
            Holiday::national('Wapenstilstand', "{$year}-11-11"),
            Holiday::national('Kerstmis', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Paasmaandag', $easter->addDay()),
            Holiday::national('OLH Hemelvaart', $easter->addDays(39)),
            Holiday::national('Pinkstermaandag', $easter->addDays(50)),
        ];
    }
}
