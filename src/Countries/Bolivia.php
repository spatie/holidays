<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Bolivia extends Country
{
    public function countryCode(): string
    {
        return 'bo';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Día de Año Nuevo' => '01-01',
            'Día del Estado Plurinacional' => '01-22',
            'Día del Trabajador' => '05-01',
            'Año Nuevo Aymara' => '06-21',
            'Día de la Independencia' => '08-06',
            'Día de Todos los Santos' => '11-02',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Lunes de Carnaval' => $easter->subWeeks(6)->subDays(6),
            'Martes de Carnaval' => $easter->subWeeks(6)->subDays(5),
            'Viernes Santo' => $easter->subDays(2),
            'Corpus Christi' => $easter->addWeeks(8)->addDays(4),
        ];
    }
}
