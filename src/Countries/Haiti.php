<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Haiti extends Country
{
    public function countryCode(): string
    {
        return 'ht';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Nouvel an / Jour de l\'Indépendance', "{$year}-01-01"),
            Holiday::national('Jour des Aieux', "{$year}-01-02"),
            Holiday::national('Fête du Travail / Fête des Travailleurs', "{$year}-05-01"),
            Holiday::national('Jour du Drapeau et de l\'Université', "{$year}-05-18"),
            Holiday::national("L'Assomption de Marie", "{$year}-08-15"),
            Holiday::national('Anniversaire de la mort de Dessalines', "{$year}-10-17"),
            Holiday::national('Toussaint', "{$year}-11-01"),
            Holiday::national('Jour des Morts', "{$year}-11-02"),
            Holiday::national('Vertières', "{$year}-11-18"),
            Holiday::national('Noël', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Carnaval/Mardi Gras', $easter->subDays(47)),
            Holiday::national('Vendredi saint', $easter->subDays(2)),
        ];
    }
}
