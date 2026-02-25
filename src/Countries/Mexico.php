<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Mexico extends Country
{
    public function countryCode(): string
    {
        return 'mx';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día Internacional de los Trabajadores' => CarbonImmutable::createFromDate($year, 5, 1),
            'Día de Independencia' => CarbonImmutable::createFromDate($year, 9, 16),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $constitutionDay = new CarbonImmutable("first monday of february {$year}")
            ->setTimezone('America/Mexico_City');

        $benitoJuarezBirth = new CarbonImmutable("third monday of March {$year}")
            ->setTimezone('America/Mexico_City');

        $revolutionDay = new CarbonImmutable("third monday of november {$year}")
            ->setTimezone('America/Mexico_City');

        $holidays = [
            'Día de la Constitución' => $constitutionDay,
            'Natalicio de Benito Juárez' => $benitoJuarezBirth,
            'Día de la Revolución' => $revolutionDay,
        ];

        $executiveChange = $this->governmentChangeDate($year);

        if ($executiveChange) {
            $holidays = array_merge($holidays, ['Cambio de Gobierno' => $executiveChange]);
        }

        return $holidays;
    }

    protected function governmentChangeDate(int $year): ?CarbonImmutable
    {
        $baseYear = 1946; // The first occurrence with president Miguel Aleman Valdes

        // Check if the current year is a transmission year
        if (($year - $baseYear) % 6 === 0) {
            return CarbonImmutable::createFromDate($year, 10, 1) // October 1st of the transmission year
                ->setTimezone('America/Mexico_City');

        }

        return null;
    }
}
