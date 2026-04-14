<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Venezuela extends Country
{
    public function countryCode(): string
    {
        return 've';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Año nuevo', "{$year}-01-01"),
            Holiday::national('Declaración de la Independencia', "{$year}-04-19"),
            Holiday::national('Día del Trabajador', "{$year}-05-01"),
            Holiday::national('Aniversario de la Batalla de Carabobo', "{$year}-06-24"),
            Holiday::national('Día de la Independencia', "{$year}-07-05"),
            Holiday::national('Natalicio de Simón Bolívar', "{$year}-07-24"),
            Holiday::national('Día de la Resistencia Indígena', "{$year}-10-12"),
            Holiday::national('Víspera de Navidad', "{$year}-12-24"),
            Holiday::national('Navidad', "{$year}-12-25"),
            Holiday::national('Día de Fin de Año', "{$year}-12-31"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Lunes de Carnaval', $easter->subDays(48)),
            Holiday::national('Martes de Carnaval', $easter->subDays(47)),
            Holiday::national('Jueves Santo', $easter->subDays(3)),
            Holiday::national('Viernes Santo', $easter->subDays(2)),
        ];
    }
}
