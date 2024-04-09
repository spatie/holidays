<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ecuador extends Country
{
    public function countryCode(): string
    {
        return 'ec';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => '01-01',
            'Día del Trabajo' => '05-01',
            'Batalla de Pichincha' => '05-24',
            'Primer Grito de la Independencia' => '08-10',
            'Independencia de Guayaquil' => '10-09',
            'Día de Los Difuntos' => '11-02',
            'Independencia de Cuenca' => '11-03',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);
        $ashWednesday = $easter->subDays(46);
        $carnivalMonday = $ashWednesday->subDays(2);
        $carnivalTuesday = $ashWednesday->subDay();

        return [
            'Viernes Santo' => $easter->subDays(2),
            'Lunes de Carnaval' => $carnivalMonday,
            'Martes de Carnaval' => $carnivalTuesday,
        ];
    }
}