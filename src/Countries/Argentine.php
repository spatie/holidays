<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Argentine extends Country
{
    public function countryCode(): string
    {
        return 'ar';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Día de Año Nuevo' => '01-01',
            'Carnaval' => '12-02',
            'Carnaval Día 2' => '13-02',
            'Día Nacional de la Memoria por la Verdad y la Justicia' => '24-04',
            'Día del Veterano y de los Caídos en la Guerra de Malvinas' => '02-04',
            'Día del Trabajador' => '05-01',
            'Revolución de Mayo' => '25-05',
            'Paso a la Inmortalidad del General Manuel Belgrano' => '20-06',
            'Día de la Independencia' => '09-07',
            'Día de la Inmaculada Concepción de María' => '08-12',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Viernes Santo' => $easter->subDays(2),
        ];
    }
}
