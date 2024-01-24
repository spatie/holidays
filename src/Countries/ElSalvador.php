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
            'Año Nuevo' => '01-01',
            'Día del Trabajo' => '05-01',
            'Día de la Madre' => '05-10',
            'Día del Padre' => '06-17',
            'Fiesta Divino Salvador del Mundo' => '08-06',
            'Día de la Independencia' => '09-15',
            'Día de Los Difuntos' => '11-02',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('America/El_Salvador');

        return [
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
            'Sábado de Gloria' => $easter->subDays(1),
        ];
    }
}
