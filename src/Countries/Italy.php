<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Italy extends Country
{
    public function countryCode(): string
    {
        return 'it';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Capodanno' => CarbonImmutable::createFromDate($year, 1, 1),
            'Epifania' => CarbonImmutable::createFromDate($year, 1, 6),
            'Festa della Liberazione' => CarbonImmutable::createFromDate($year, 4, 25),
            'Festa dei Lavoratori' => CarbonImmutable::createFromDate($year, 5, 1),
            'Festa della Repubblica' => CarbonImmutable::createFromDate($year, 6, 2),
            'Assunzione di Maria' => CarbonImmutable::createFromDate($year, 8, 15),
            'Ognissanti' => CarbonImmutable::createFromDate($year, 11, 1),
            'Immacolata Concezione' => CarbonImmutable::createFromDate($year, 12, 8),
            'Natale' => CarbonImmutable::createFromDate($year, 12, 25),
            'Santo Stefano' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Lunedì di Pasqua' => $easter->addDay(),
        ];
    }
}
