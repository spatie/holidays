<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Chile extends Country
{
    public function countryCode(): string
    {
        return 'cl';
    }

    protected function allHolidays(int $year): array
    {
        return [
            Holiday::national('Año Nuevo', "{$year}-01-01"),
            Holiday::national('Viernes Santo', "{$year}-03-29"),
            Holiday::national('Sábado Santo', "{$year}-03-30"),
            Holiday::national('Día del Trabajador', "{$year}-05-01"),
            Holiday::national('Día de las Glorias Navales', "{$year}-05-21"),
            Holiday::national('Día Nacional de los Pueblos Indígenas', "{$year}-06-20"),
            Holiday::national('San Pedro y San Pablo', "{$year}-06-29"),
            Holiday::national('Día de la Virgen del Carmen', "{$year}-07-16"),
            Holiday::national('Asunción de la Virgen', "{$year}-08-15"),
            Holiday::national('Independencia Nacional', "{$year}-09-18"),
            Holiday::national('Día de las Glorias del Ejército', "{$year}-09-19"),
            Holiday::national('Feriado añadido de Fiestas Patrias', "{$year}-09-20"),
            Holiday::national('Encuentro de Dos Mundos', "{$year}-10-12"),
            Holiday::national('Día de las Iglesias Evangélicas', "{$year}-10-31"),
            Holiday::national('Día de Todos los Santos', "{$year}-11-01"),
            Holiday::national('Inmaculada Concepción', "{$year}-12-08"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ];
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Día de la Reforma', $easter->subDays(2)),
        ];
    }
}
