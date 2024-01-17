<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Belgium extends Country
{
    public function countryCode(): string
    {
        return 'be';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return  array_merge([
            'Nieuwjaar' => '01-01',
            'Dag van de Arbeid' => '05-14',
            'Nationale Feestdag' => '07-21',
            'OLV Hemelvaart' => '08-18',
            'Allerheiligen' => '11-01',
            'Wapenstilstand' => '11-11',
            'Kerstmis' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Brussels');

        return [
            'Paasmaandag' => $easter->addDay(),
            'OLH Hemelvaart' => $easter->addDays(39),
            'Pinkstermaandag' => $easter->addDays(50),
        ];
    }
}
