<?php

namespace Spatie\Holidays\Countries;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class Honduras extends Country
{
    public function countryCode(): string
    {
        return 'hn';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Año Nuevo', "{$year}-01-01"),
            Holiday::national('Día del Trabajo', "{$year}-05-01"),
            Holiday::national('Día de la Independencia', "{$year}-09-15"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);
        $morazanicWeek = $this->getMorazanicWeek($year);
        $dayOfTheAmericas = $this->getDayOfTheAmericas($year, $easter);

        return array_merge([
            Holiday::national('Jueves Santo', $easter->subDays(3)),
            Holiday::national('Viernes Santo', $easter->subDays(2)),
            Holiday::national('Sábado Santo', $easter->subDays(1)),
            Holiday::national('Día de las Américas', $dayOfTheAmericas),
            Holiday::national('Feriado Morazánico (3 Octubre)', $morazanicWeek['miercoles']),
            Holiday::national('Feriado Morazánico (12 Octubre)', $morazanicWeek['jueves']),
            Holiday::national('Feriado Morazánico (21 Octubre)', $morazanicWeek['viernes']),
        ]);
    }

    protected function getDayOfTheAmericas(int $year, CarbonImmutable $easter): CarbonImmutable
    {
        $date = CarbonImmutable::createFromDate($year, 4, 14);

        $juevesSanto = $easter->subDays(3);
        $sabadoSanto = $easter->subDays(1);
        $lunesPosteriorSS = $sabadoSanto->addDays(2);

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

    /** @return array<string, CarbonImmutable> */
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
