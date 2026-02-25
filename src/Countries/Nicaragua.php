<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Nicaragua extends Country
{
    public function countryCode(): string
    {
        return 'ni';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día internacional de los trabajadores' => CarbonImmutable::createFromDate($year, 5, 1),
            'Día de las madres' => CarbonImmutable::createFromDate($year, 5, 30),
            'Aniversario de la revolución' => CarbonImmutable::createFromDate($year, 7, 19),
            'Aniversario de la batalla de san jacinto' => CarbonImmutable::createFromDate($year, 9, 14),
            'Aniversario de la independencia' => CarbonImmutable::createFromDate($year, 9, 15),
            'Día de la inmaculada concepción' => CarbonImmutable::createFromDate($year, 12, 8),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Jueves santo' => $easter->subDays(3),
            'Viernes santo' => $easter->subDays(2),
        ];
    }
}
