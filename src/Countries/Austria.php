<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Austria extends Country
{
    public function countryCode(): string
    {
        return 'at';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Neujahr' => '01-01',
            'Heilige Drei Könige' => '01-06',
            'Staatsfeiertag' => '05-01',
            'Mariä Himmelfahrt' => '08-15',
            'Nationalfeiertag' => '10-26',
            'Allerheiligen' => '11-01',
            'Mariä Empfängnis' => '12-08',
            'Christtag' => '12-25',
            'Stefanitag' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Ostermontag' => $easter->addDay(),
            'Christi Himmelfahrt' => $easter->addDays(39),
            'Pfingstmontag' => $easter->addDays(50),
            'Fronleichnam' => $easter->addDays(60),
        ];
    }
}
