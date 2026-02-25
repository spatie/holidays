<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Andorra extends Country
{
    public function countryCode(): string
    {
        return 'ad';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Any nou' => CarbonImmutable::createFromDate($year, 1, 1),
            'Reis' => CarbonImmutable::createFromDate($year, 1, 6),
            'Dia de la Constitució' => CarbonImmutable::createFromDate($year, 3, 14),
            'Festa del Treball' => CarbonImmutable::createFromDate($year, 5, 1),
            'Assumpció' => CarbonImmutable::createFromDate($year, 8, 15),
            'Mare de Déu de Meritxell' => CarbonImmutable::createFromDate($year, 9, 8),
            'Tots Sants' => CarbonImmutable::createFromDate($year, 11, 1),
            'Immaculada Concepció' => CarbonImmutable::createFromDate($year, 11, 8),
            'Nadal' => CarbonImmutable::createFromDate($year, 12, 25),
            'Sant Esteve' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Divendres Sant' => $easter->subDays(2),
            'Dilluns de Pasqua' => $easter->addDay(),
            'Dilluns de Pentecosta' => $easter->addDays(50),
        ];
    }
}
