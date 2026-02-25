<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Peru extends Country
{
    public function countryCode(): string
    {
        return 'pe';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día del Trabajo' => CarbonImmutable::createFromDate($year, 5, 1),
            'Batalla de Arica y Día de la bandera' => CarbonImmutable::createFromDate($year, 6, 7),
            'Día de San Pedro y San Pablo' => CarbonImmutable::createFromDate($year, 6, 29),
            'Día de la Fuerza Aérea del Perú' => CarbonImmutable::createFromDate($year, 7, 23),
            'Día de la Independencia' => CarbonImmutable::createFromDate($year, 7, 28),
            'Fiestas Patrias' => CarbonImmutable::createFromDate($year, 7, 29),
            'Batalla de Junín' => CarbonImmutable::createFromDate($year, 8, 6),
            'Santa Rosa de Lima' => CarbonImmutable::createFromDate($year, 8, 30),
            'Combate de Angamos' => CarbonImmutable::createFromDate($year, 10, 8),
            'Día de Todos los Santos' => CarbonImmutable::createFromDate($year, 11, 1),
            'Inmaculada Concepción' => CarbonImmutable::createFromDate($year, 12, 8),
            'Batalla de Ayacucho' => CarbonImmutable::createFromDate($year, 12, 9),
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
        ];
    }
}
