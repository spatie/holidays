<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Chile extends Country
{
    public function countryCode(): string
    {
        return 'cl';
    }

    protected function allHolidays(int $year): array
    {
        return [
            'Año Nuevo' => '01-01',
            'Viernes Santo' => '03-29',
            'Sábado Santo' => '03-30',
            'Día del Trabajador' => '05-01',
            'Día de las Glorias Navales' => '05-21',
            'Día Nacional de los Pueblos Indígenas' => '06-20',
            'San Pedro y San Pablo' => '06-29',
            'Día de la Virgen del Carmen' => '07-16',
            'Asunción de la Virgen' => '08-15',
            'Independencia Nacional' => '09-18',
            'Día de las Glorias del Ejército' => '09-19',
            'Feriado añadido de Fiestas Patrias' => '09-20',
            'Encuentro de Dos Mundos' => '10-12',
            'Día de las Iglesias Evangélicas' => '10-31',
            'Día de Todos los Santos' => '11-01',
            'Inmaculada Concepción' => '12-08',
            'Navidad' => '12-25',
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Jueves santo' => $easter->subDays(3),
            'Viernes santo' => $easter->subDays(2),
        ];
    }
}
