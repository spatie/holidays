<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Panama extends Country
{

    public function countryCode(): string
    {
        return 'pa';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => '01-01',
            'Día de los Mártires' => '01-09',
            'Día del Trabajo' => '05-01',
            'Separación de Panamá de Colombia' => '11-03',
            'Día de Colón' => '11-05',
            'Grito de independencia de La Villa de Los Santos' => '11-10',
            'Independencia de Panamá de España' => '11-25',
            'Día de la Madre' => '12-08',
            'Duelo Nacional por la Invasión de Estados Unidos a Panamá' => '12-20',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('America/Panama');

        return [
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
            'Sábado de Gloria' => $easter->subDays(1),
        ];
    }
}
