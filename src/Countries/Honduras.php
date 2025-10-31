<?php

namespace Spatie\Holidays\Countries;

use Carbon\Carbon;
use Carbon\CarbonImmutable;

class Honduras extends Country
{
    public function countryCode(): string
    {
        return 'hn';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => '01-01',
            'Día del Trabajo' => '05-01',
            'Día de la Independencia' => '09-15',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);
        $morazanicWeek = $this->getMorazanicWeek($year);
        $dayOfTheAmericas = $this->getDayOfTheAmericas($year, $easter);

        return array_merge([
            // Semana Santa (Inamovibles)
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
            'Sábado Santo' => $easter->subDays(1),

            // Día de las Américas (Movible)
            'Día de las Américas' => $dayOfTheAmericas,

            // Semana Morazánica (Unificados y Movibles)
            'Feriado Morazánico (3 Octubre)' => $morazanicWeek['miercoles'],
            'Feriado Morazánico (12 Octubre)' => $morazanicWeek['jueves'],
            'Feriado Morazánico (21 Octubre)' => $morazanicWeek['viernes'],
        ]);
    }

    protected function getDayOfTheAmericas(int $year, CarbonImmutable $easter): CarbonImmutable
    {
        $date = CarbonImmutable::createFromDate($year, 4, 14);

        $juevesSanto = $easter->subDays(3);
        $sabadoSanto = $easter->subDays(1);
        $lunesPosteriorSS = $sabadoSanto->addDays(2);

        // 1. Si cae entre Martes (2) y Viernes (5)
        if ($date->isBetween($date->startOfWeek()->addDay(), $date->endOfWeek()->subDays(2))) {
            if ($date->isBetween($juevesSanto->subDays(2), $sabadoSanto)) {
                return $lunesPosteriorSS;
            }

            return $date->next(Carbon::MONDAY);
        }

        if ($date->isWeekend()) {
            return $date;
        }

        return $date;
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function getMorazanicWeek(int $year): array
    {
        $startOfMonth = CarbonImmutable::createFromDate($year, 10, 1);

        $miercoles = $startOfMonth->firstOfMonth(Carbon::WEDNESDAY);

        return [
            'miercoles' => $miercoles,
            'jueves' => $miercoles->addDay(),
            'viernes' => $miercoles->addDays(2),
        ];
    }
}
