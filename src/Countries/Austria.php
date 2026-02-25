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
            'Neujahr' => CarbonImmutable::createFromDate($year, 1, 1),
            'Heilige Drei Könige' => CarbonImmutable::createFromDate($year, 1, 6),
            'Staatsfeiertag' => CarbonImmutable::createFromDate($year, 5, 1),
            'Mariä Himmelfahrt' => CarbonImmutable::createFromDate($year, 8, 15),
            'Nationalfeiertag' => CarbonImmutable::createFromDate($year, 10, 26),
            'Allerheiligen' => CarbonImmutable::createFromDate($year, 11, 1),
            'Mariä Empfängnis' => CarbonImmutable::createFromDate($year, 12, 8),
            'Christtag' => CarbonImmutable::createFromDate($year, 12, 25),
            'Stefanitag' => CarbonImmutable::createFromDate($year, 12, 26),
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
