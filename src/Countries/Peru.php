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
            'Año nuevo' => '01-01',
            'Día del Trabajo' => '05-01',
            'Batalla de Arica y Día de la bandera' => '06-07',
            'Día de San Pedro y San Pablo' => '06-29',
            'Día de la Fuerza Aérea del Perú' => '07-23',
            'Día de la Independencia' => '07-28',
            'Fiestas Patrias' => '07-29',
            'Batalla de Junín' => '08-06',
            'Santa Rosa de Lima' => '08-30',
            'Combate de Angamos' => '10-08',
            'Día de Todos los Santos' => '11-01',
            'Inmaculada Concepción' => '12-08',
            'Batalla de Ayacucho' => '12-09',
            'Navidad' => '12-25',
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
