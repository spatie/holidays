<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Spain extends Country
{
    public function countryCode(): string
    {
        return 'es';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => '01-01',
            'Epifanía del Señor' => '01-06',
            'Día del Trabajador' => '05-01',
            'Asunción de la Virgen' => '08-15',
            'Fiesta Nacional de España' => '10-12',
            'Todos los Santos' => '11-01',
            'Día de la Constitución Española' => '12-06',
            'Inmaculada Concepción' => '12-08',
            'Navidad' => '12-25'
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Madrid');

        return [
            'Viernes Santo' => $easter->subDays(2),
        ];
    }
}
