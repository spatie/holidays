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
            'Año nuevo' => '01-01',
            'Declaración de la Independencia' => '04-19',
            'Día del Trabajador' => '05-01',
            'Aniversario de la Batalla de Carabobo' => '06-24',
            'Día de la Independencia' => '07-05',
            'Natalicio de Simón Bolívar' => '07-24',
            'Día de la Resistencia Indígena' => '10-12',
            'Víspera de Navidad' => '12-24',
            'Navidad' => '12-25',
            'Día de Fin de Año' => '12-31',
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
