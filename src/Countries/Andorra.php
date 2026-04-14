<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Andorra extends Country
{
    public function countryCode(): string
    {
        return 'ad';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Any nou', "{$year}-01-01"),
            Holiday::national('Reis', "{$year}-01-06"),
            Holiday::national('Dia de la Constitució', "{$year}-03-14"),
            Holiday::national('Festa del Treball', "{$year}-05-01"),
            Holiday::national('Assumpció', "{$year}-08-15"),
            Holiday::national('Mare de Déu de Meritxell', "{$year}-09-08"),
            Holiday::national('Tots Sants', "{$year}-11-01"),
            Holiday::national('Immaculada Concepció', "{$year}-11-08"),
            Holiday::national('Nadal', "{$year}-12-25"),
            Holiday::national('Sant Esteve', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Divendres Sant', $easter->subDays(2)),
            Holiday::national('Dilluns de Pasqua', $easter->addDay()),
            Holiday::national('Dilluns de Pentecosta', $easter->addDays(50)),
        ];
    }
}
