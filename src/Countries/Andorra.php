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
            'Any nou' => '01-01',
            'Reis' => '01-06',
            'Dia de la Constitució' => '03-14',
            'Festa del Treball' => '05-01',
            'Assumpció' => '08-15',
            'Mare de Déu de Meritxell' => '09-08',
            'Tots Sants' => '11-01',
            'Immaculada Concepció' => '11-08',
            'Nadal' => '12-25',
            'Sant Esteve' => '12-26',
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
