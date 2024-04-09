<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ecuador extends Country
{
    public function countryCode(): string
    {
        return 'ec';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => '01-01',
        ], $this->variableHolidays($year));
    }

    public function nearestDay(int $year, int $month, int $day)
    {
        $date = CarbonImmutable::createFromDate($year, $month, $day);

        if($date->is('Tuesday') || $date->is('Saturday')) {
            return $date->subDay();
        }

        if($date->is('Sunday')) {
            return $date->addDay();
        }

        if($date->is('Wednesday') || $date->is('Thursday')) {
            return $date->next(CarbonImmutable::FRIDAY);
        }

        return $date;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);
        $ashWednesday = $easter->subDays(46);
        $carnivalMonday = $ashWednesday->subDays(2);
        $carnivalTuesday = $ashWednesday->subDay();

        return [
            'Viernes Santo' => $easter->subDays(2),
            'Lunes de Carnaval' => $carnivalMonday,
            'Martes de Carnaval' => $carnivalTuesday,
            'Día del Trabajo' =>  $this->nearestDay($year, 5, 1),
            'Batalla de Pichincha' =>  $this->nearestDay($year, 5, 24),
            'Primer Grito de la Independencia' =>  $this->nearestDay($year, 8, 10),
            'Independencia de Guayaquil' =>  $this->nearestDay($year, 10, 9),
            'Día de Los Difuntos' =>  $this->nearestDay($year, 11, 2),
            'Independencia de Cuenca' =>  $this->nearestDay($year, 11, 3),
            'Navidad' =>  $this->nearestDay($year, 12, 25),
        ];
    }
}