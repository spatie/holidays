<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Venezuela extends Country
{
    public function countryCode(): string
    {
        return 've';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Declaración de la Independencia' => CarbonImmutable::createFromDate($year, 4, 19),
            'Día del Trabajador' => CarbonImmutable::createFromDate($year, 5, 1),
            'Aniversario de la Batalla de Carabobo' => CarbonImmutable::createFromDate($year, 6, 24),
            'Día de la Independencia' => CarbonImmutable::createFromDate($year, 7, 5),
            'Natalicio de Simón Bolívar' => CarbonImmutable::createFromDate($year, 7, 24),
            'Día de la Resistencia Indígena' => CarbonImmutable::createFromDate($year, 10, 12),
            'Víspera de Navidad' => CarbonImmutable::createFromDate($year, 12, 24),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
            'Día de Fin de Año' => CarbonImmutable::createFromDate($year, 12, 31),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Lunes de Carnaval' => $easter->subDays(48),
            'Martes de Carnaval' => $easter->subDays(42),
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
        ];
    }
}
