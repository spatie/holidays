<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Argentine extends Country
{
    public function countryCode(): string
    {
        return 'ar';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Día de Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Carnaval' => CarbonImmutable::createFromDate($year, 12, 2),
            'Carnaval Día 2' => CarbonImmutable::createFromDate($year, 2, 13),
            'Día Nacional de la Memoria por la Verdad y la Justicia' => CarbonImmutable::createFromDate($year, 4, 24),
            'Día del Veterano y de los Caídos en la Guerra de Malvinas' => CarbonImmutable::createFromDate($year, 2, 4),
            'Día del Trabajador' => CarbonImmutable::createFromDate($year, 5, 1),
            'Revolución de Mayo' => CarbonImmutable::createFromDate($year, 5, 25),
            'Paso a la Inmortalidad del General Manuel Belgrano' => CarbonImmutable::createFromDate($year, 6, 20),
            'Día de la Independencia' => CarbonImmutable::createFromDate($year, 9, 7),
            'Día de la Inmaculada Concepción de María' => CarbonImmutable::createFromDate($year, 8, 12),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Viernes Santo' => $easter->subDays(2),
        ];
    }
}
