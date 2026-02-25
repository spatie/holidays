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
            'Día de Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día del Estado Plurinacional' => CarbonImmutable::createFromDate($year, 1, 22),
            'Día del Trabajador' => CarbonImmutable::createFromDate($year, 5, 1),
            'Año Nuevo Aymara' => CarbonImmutable::createFromDate($year, 6, 21),
            'Día de la Independencia' => CarbonImmutable::createFromDate($year, 8, 6),
            'Día de Todos los Santos' => CarbonImmutable::createFromDate($year, 11, 2),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
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
