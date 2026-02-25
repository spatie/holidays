<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class ElSalvador extends Country
{
    public function countryCode(): string
    {
        return 'sv';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día del Trabajo' => CarbonImmutable::createFromDate($year, 5, 1),
            'Día de la Madre' => CarbonImmutable::createFromDate($year, 5, 10),
            'Día del Padre' => CarbonImmutable::createFromDate($year, 6, 17),
            'Fiesta Divino Salvador del Mundo' => CarbonImmutable::createFromDate($year, 8, 6),
            'Día de la Independencia' => CarbonImmutable::createFromDate($year, 9, 15),
            'Día de Los Difuntos' => CarbonImmutable::createFromDate($year, 11, 2),
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
            'Sábado de Gloria' => $easter->subDay(),
        ];
    }
}
