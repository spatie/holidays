<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class DominicanRepublic extends Country
{
    public function countryCode(): string
    {
        return 'do';
    }

    /** @return array<string, CarbonImmutable | string> */
    protected function allHolidays(int $year): array
    {
        return [
            'Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día de la Altagracia' => CarbonImmutable::createFromDate($year, 1, 21),
            'Día de Duarte' => CarbonImmutable::createFromDate($year, 1, 26),
            'Día de la Independencia' => CarbonImmutable::createFromDate($year, 2, 27),
            'Día del Trabajo' => CarbonImmutable::createFromDate($year, 5, 1),
            'Día de la Restauración' => CarbonImmutable::createFromDate($year, 8, 16),
            'Día de las Mercedes' => CarbonImmutable::createFromDate($year, 9, 24),
            'Día de la Constitución' => CarbonImmutable::createFromDate($year, 11, 6),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
        ];
    }
}
