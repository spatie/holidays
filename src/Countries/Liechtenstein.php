<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Liechtenstein extends Country
{
    public function countryCode(): string
    {
        return 'li';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Neujahr' => '01-01',
            'Heilige Drei Könige' => '01-06',
            'Tag der Arbeit' => '05-01',
            'Staatsfeiertag / Mariä Himmelfahrt' => '08-15',
            'Mariä Geburt' => '09-08',
            'Allerheiligen' => '11-01',
            'Mariä Empfängnis' => '12-08',
            'Weihnachten' => '12-25',
            'Stephanstag' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Ostermontag' => $easter->addDay(),
            'Auffahrt' => $easter->addDays(39),
            'Pfingstmontag' => $easter->addDays(50),
            'Fronleichnam' => $easter->addDays(60),
        ];
    }
}
