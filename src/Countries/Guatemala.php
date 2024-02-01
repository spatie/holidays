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
            'Año Nuevo' => '01-01',
            'Día de los Trabajadores' => '05-01',
            'Día del Ejército' => '06-31',
            'Día de la Independencia' => '09-15',
            'Día de la Revolución' => '10-20',
            'Día de Todos los Santos' => '11-01',
            'Navidad' => '12-25',
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
