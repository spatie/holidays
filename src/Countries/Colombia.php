<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
Use Carbon\Carbon;

class Colombia extends Country
{
    public function countryCode(): string
    {
        return 'co';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año nuevo' => '01-01',
            'Día de los Reyes Magos' => '01-08',
            'Día de San José' => '03-25',
            'Día del Trabajo' => '05-01',
            'Día de la Ascensión' => '05-13',
            'Corpus Christi' => '06-03',
            'Día del Sagrado Corazón' => '06-10',
            'Día de San Pedro y San Pablo' => '07-01',
            'Dia de la Independencia' => '07-20',
            'Batalla de Boyacá' => '08-07',
            'Asunción de la Virgen' => '08-19',
            'Día de la Raza' => '10-14',
            'Día de todos los Santos' => '11-04',
            'Día de la Independencia de Cartagena' => '11-11',
            'Día de la Inmaculada Concepción' => '12-08',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
        ];
    }
}
