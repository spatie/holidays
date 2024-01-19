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
            'Año nuevo' => '01-01',
            'Día internacional de los trabajadores' => '05-01',
            'Día de las madres' => '05-30',
            'Aniversario de la revolución' => '07-19',
            'Aniversario de la batalla de san jacinto' => '09-14',
            'Aniversario de la independencia' => '09-15',
            'Día de la inmaculada concepción' => '12-08',
            'Navidad' => '12-25',
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
