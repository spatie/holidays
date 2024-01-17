<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Netherlands extends Country
{
    public function countryCode(): string
    {
        return 'nl';
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nieuwjaar' => '01-01',
            'Bevrijdingsdag' => '05-05',
            'Kerstmis' => '12-25',
            '2de Kerstdag' => '12-26',
            'Oudjaar' => '12-31',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $koningsDag = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-04-27");

        if ($koningsDag->isSunday()) {
            $koningsDag = $koningsDag->subDay();
        }

        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Amsterdam');

        return [
            'Koningsdag' => $koningsDag,
            'Goede vrijdag' => $easter->subDays(2),
            'Paasmaandag' => $easter->addDay(),
            'OLH Hemelvaart' => $easter->addDays(39),
            'Pinksteren' => $easter->addDays(49),
            'Pinkstermaandag' => $easter->addDays(50),
        ];
    }
}
