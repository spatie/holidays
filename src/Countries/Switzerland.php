<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Switzerland extends Country
{
    public function countryCode(): string
    {
        return 'ch';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Neujahr' => '01-01',
            'Berchtoldstag' => '01-02',
            'Bundesfeier' => '08-01',
            'Weihnachtstag' => '12-25',
            'Stephanstag' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Karfreitag' => $easter->subDays(2),
            'Ostermontag' => $easter->addDay(),
            'Auffahrt' => $easter->addDays(39),
            'Pfingstmontag' => $easter->addDays(50),
        ];
    }
}
