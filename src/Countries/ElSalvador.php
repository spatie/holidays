<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class ElSalvador extends Country
{
    public function countryCode(): string
    {
        return 'sv';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Año Nuevo', "{$year}-01-01"),
            Holiday::national('Día del Trabajo', "{$year}-05-01"),
            Holiday::national('Día de la Madre', "{$year}-05-10"),
            Holiday::national('Día del Padre', "{$year}-06-17"),
            Holiday::national('Fiesta Divino Salvador del Mundo', "{$year}-08-06"),
            Holiday::national('Día de la Independencia', "{$year}-09-15"),
            Holiday::national('Día de Los Difuntos', "{$year}-11-02"),
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
            Holiday::national('Sábado de Gloria', $easter->subDay()),
        ];
    }
}
