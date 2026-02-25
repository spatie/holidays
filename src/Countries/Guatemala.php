<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Guatemala extends Country
{
    public function countryCode(): string
    {
        return 'gt';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día de los Trabajadores' => CarbonImmutable::createFromDate($year, 5, 1),
            'Día del Ejército' => CarbonImmutable::createFromDate($year, 6, 31),
            'Día de la Independencia' => CarbonImmutable::createFromDate($year, 9, 15),
            'Día de la Revolución' => CarbonImmutable::createFromDate($year, 10, 20),
            'Día de Todos los Santos' => CarbonImmutable::createFromDate($year, 11, 1),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
            'Sábado Santo' => $easter->subDays(1),
        ];
    }
}
