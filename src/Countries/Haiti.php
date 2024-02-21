<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Haiti extends Country
{
    public function countryCode(): string
    {
        return 'ht';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nouvel an / Jour de l\'Indépendance' => '01-01',
            'Jour des Aieux' => '01-2',
            'Fête du Travail / Fête des Travailleurs' => '05-01',
            'Jour du Drapeau et de l\'Université' => '05-18',
            'L\'Assomption de Marie' => '08-15',
            'Anniversaire de la mort de Dessalines' => '10-17',
            'Toussaint' => '11-01',
            'Jour des Morts' => '11-02',
            'Vertières' => '11-18',
            'Noël' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Carnaval/Mardi Gras' => $easter->subDays(47),
            'Vendredi saint' => $easter->subDays(2),
        ];
    }
}
