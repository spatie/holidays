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
            'Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Viernes Santo' => CarbonImmutable::createFromDate($year, 3, 29),
            'Sábado Santo' => CarbonImmutable::createFromDate($year, 3, 30),
            'Día del Trabajador' => CarbonImmutable::createFromDate($year, 5, 1),
            'Día de las Glorias Navales' => CarbonImmutable::createFromDate($year, 5, 21),
            'Día Nacional de los Pueblos Indígenas' => CarbonImmutable::createFromDate($year, 6, 20),
            'San Pedro y San Pablo' => CarbonImmutable::createFromDate($year, 6, 29),
            'Día de la Virgen del Carmen' => CarbonImmutable::createFromDate($year, 7, 16),
            'Asunción de la Virgen' => CarbonImmutable::createFromDate($year, 8, 15),
            'Independencia Nacional' => CarbonImmutable::createFromDate($year, 9, 18),
            'Día de las Glorias del Ejército' => CarbonImmutable::createFromDate($year, 9, 19),
            'Feriado añadido de Fiestas Patrias' => CarbonImmutable::createFromDate($year, 9, 20),
            'Encuentro de Dos Mundos' => CarbonImmutable::createFromDate($year, 10, 12),
            'Día de las Iglesias Evangélicas' => CarbonImmutable::createFromDate($year, 10, 31),
            'Día de Todos los Santos' => CarbonImmutable::createFromDate($year, 11, 1),
            'Inmaculada Concepción' => CarbonImmutable::createFromDate($year, 12, 8),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
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
