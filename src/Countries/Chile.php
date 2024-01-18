<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Chile extends Country
{
    public function countryCode(): string
    {
        return 'cl';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => '01-01',
            'Día del Trabajo' => '05-01',
            'Día de las Glorias Navales' => '05-21',
            'Día Nacional de los Pueblos Indígenas' => '06-20',
            'San Pedro y San Pablo' => '06-29',
            'Virgen del Carmen' => '07-16',
            'Asunción de la Virgen' => '08-15',
            'Día de la Independencia' => '09-18',
            'Día de las Glorias del Ejército' => '09-19',
            'Encuentro de Dos Mundos' => '10-12',
            'Día Nacional de las Iglesias Evangélicas y Protestantes' => '10-31',
            'Día de Todos los Santos' => '11-01',
            'Inmaculada Concepción' => '12-08',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))->setTimezone('America/Sao_Paulo');

        return [
            'Viernes Santo' => $easter->subDays(2),
            'Sábado Santo' => $easter->subDays(1),
            'Domingo de Pascua' => $easter,
        ];
    }
}
