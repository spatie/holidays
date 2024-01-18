<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class DominicanRepublic extends Country
{
    public function countryCode(): string
    {
        return 'do';
    }

    /** @return array<string, CarbonImmutable | string> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => '01-01',
            'Día de la Altagracia' => '01-21',
            'Día de Duarte' => '01-26',
            'Día de la Independencia' => '02-27',
            'Día del Trabajo' => '05-01',
            'Día de la Restauración' => '08-16',
            'Día de las Mercedes' => '09-24',
            'Día de la Constitución' => '11-06',
            'Día de la Virgen de la Altagracia' => '12-08',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter =  CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('America/Santo_Domingo');

        return [
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
        ];
    }
}
