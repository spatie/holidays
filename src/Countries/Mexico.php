<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class Mexico extends Country
{
    public function countryCode(): string
    {
        return 'mx';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Año Nuevo', "{$year}-01-01"),
            Holiday::national('Día Internacional de los Trabajadores', "{$year}-05-01"),
            Holiday::national('Día de Independencia', "{$year}-09-16"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $constitutionDay = new CarbonImmutable("first monday of february {$year}")
            ->setTimezone('America/Mexico_City');

        $benitoJuarezBirth = new CarbonImmutable("third monday of March {$year}")
            ->setTimezone('America/Mexico_City');

        $revolutionDay = new CarbonImmutable("third monday of november {$year}")
            ->setTimezone('America/Mexico_City');

        $holidays = [
            Holiday::national('Día de la Constitución', $constitutionDay),
            Holiday::national('Natalicio de Benito Juárez', $benitoJuarezBirth),
            Holiday::national('Día de la Revolución', $revolutionDay),
        ];

        $executiveChange = $this->governmentChangeDate($year);

        if ($executiveChange) {
            $holidays[] = Holiday::national('Cambio de Gobierno', $executiveChange);
        }

        return $holidays;
    }

    protected function governmentChangeDate(int $year): ?CarbonImmutable
    {
        $baseYear = 1946;

        if (($year - $baseYear) % 6 === 0) {
            return CarbonImmutable::createFromDate($year, 10, 1)
                ->setTimezone('America/Mexico_City');
        }

        return null;
    }
}
