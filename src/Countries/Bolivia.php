<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Bolivia extends Country
{
    public function countryCode(): string
    {
        return 'bo';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Día de Año Nuevo', "{$year}-01-01"),
            Holiday::national('Día del Estado Plurinacional', "{$year}-01-22"),
            Holiday::national('Día del Trabajador', "{$year}-05-01"),
            Holiday::national('Año Nuevo Aymara', "{$year}-06-21"),
            Holiday::national('Día de la Independencia', "{$year}-08-06"),
            Holiday::national('Día de Todos los Santos', "{$year}-11-02"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Lunes de Carnaval', $easter->subWeeks(6)->subDays(6)),
            Holiday::national('Martes de Carnaval', $easter->subWeeks(6)->subDays(5)),
            Holiday::national('Viernes Santo', $easter->subDays(2)),
            Holiday::national('Corpus Christi', $easter->addWeeks(8)->addDays(4)),
        ];
    }
}
