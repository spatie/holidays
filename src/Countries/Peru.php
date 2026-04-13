<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Peru extends Country
{
    public function countryCode(): string
    {
        return 'pe';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Año nuevo', "{$year}-01-01"),
            Holiday::national('Día del Trabajo', "{$year}-05-01"),
            Holiday::national('Batalla de Arica y Día de la bandera', "{$year}-06-07"),
            Holiday::national('Día de San Pedro y San Pablo', "{$year}-06-29"),
            Holiday::national('Día de la Fuerza Aérea del Perú', "{$year}-07-23"),
            Holiday::national('Día de la Independencia', "{$year}-07-28"),
            Holiday::national('Fiestas Patrias', "{$year}-07-29"),
            Holiday::national('Batalla de Junín', "{$year}-08-06"),
            Holiday::national('Santa Rosa de Lima', "{$year}-08-30"),
            Holiday::national('Combate de Angamos', "{$year}-10-08"),
            Holiday::national('Día de Todos los Santos', "{$year}-11-01"),
            Holiday::national('Inmaculada Concepción', "{$year}-12-08"),
            Holiday::national('Batalla de Ayacucho', "{$year}-12-09"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Jueves Santo', $easter->subDays(3)),
            Holiday::national('Viernes Santo', $easter->subDays(2)),
        ];
    }
}
