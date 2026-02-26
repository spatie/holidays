<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class DominicanRepublic extends Country
{
    public function countryCode(): string
    {
        return 'do';
    }

    /** @return array<Holiday> */
    protected function allHolidays(int $year): array
    {
        return [
            Holiday::national('Año Nuevo', "{$year}-01-01"),
            Holiday::national('Día de la Altagracia', "{$year}-01-21"),
            Holiday::national('Día de Duarte', "{$year}-01-26"),
            Holiday::national('Día de la Independencia', "{$year}-02-27"),
            Holiday::national('Día del Trabajo', "{$year}-05-01"),
            Holiday::national('Día de la Restauración', "{$year}-08-16"),
            Holiday::national('Día de las Mercedes', "{$year}-09-24"),
            Holiday::national('Día de la Constitución', "{$year}-11-06"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ];
    }
}
