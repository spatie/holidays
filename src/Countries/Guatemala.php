<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Guatemala extends Country
{
    public function countryCode(): string
    {
        return 'gt';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Año Nuevo', "{$year}-01-01"),
            Holiday::national('Día de los Trabajadores', "{$year}-05-01"),
            Holiday::national('Día del Ejército', "{$year}-06-30"),
            Holiday::national('Día de la Independencia', "{$year}-09-15"),
            Holiday::national('Día de la Revolución', "{$year}-10-20"),
            Holiday::national('Día de Todos los Santos', "{$year}-11-01"),
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
            Holiday::national('Sábado Santo', $easter->subDays(1)),
        ];
    }
}
