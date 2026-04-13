<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Argentine extends Country
{
    public function countryCode(): string
    {
        return 'ar';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Día de Año Nuevo', "{$year}-01-01"),
            Holiday::national('Carnaval', "{$year}-02-12"),
            Holiday::national('Carnaval Día 2', "{$year}-02-13"),
            Holiday::national('Día Nacional de la Memoria por la Verdad y la Justicia', "{$year}-03-24"),
            Holiday::national('Día del Veterano y de los Caídos en la Guerra de Malvinas', "{$year}-04-02"),
            Holiday::national('Día del Trabajador', "{$year}-05-01"),
            Holiday::national('Revolución de Mayo', "{$year}-05-25"),
            Holiday::national('Paso a la Inmortalidad del General Manuel Belgrano', "{$year}-06-20"),
            Holiday::national('Día de la Independencia', "{$year}-07-09"),
            Holiday::national('Día de la Inmaculada Concepción de María', "{$year}-12-08"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Viernes Santo', $easter->subDays(2)),
        ];
    }
}
