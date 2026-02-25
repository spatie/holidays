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
            'Nouvel an / Jour de l\'Indépendance' => CarbonImmutable::createFromDate($year, 1, 1),
            'Jour des Aieux' => CarbonImmutable::createFromDate($year, 1, 2),
            'Fête du Travail / Fête des Travailleurs' => CarbonImmutable::createFromDate($year, 5, 1),
            'Jour du Drapeau et de l\'Université' => CarbonImmutable::createFromDate($year, 5, 18),
            "L'Assomption de Marie" => CarbonImmutable::createFromDate($year, 8, 15),
            'Anniversaire de la mort de Dessalines' => CarbonImmutable::createFromDate($year, 10, 17),
            'Toussaint' => CarbonImmutable::createFromDate($year, 11, 1),
            'Jour des Morts' => CarbonImmutable::createFromDate($year, 11, 2),
            'Vertières' => CarbonImmutable::createFromDate($year, 11, 18),
            'Noël' => CarbonImmutable::createFromDate($year, 12, 25),
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
