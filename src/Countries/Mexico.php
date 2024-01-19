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
            'Año Nuevo' => '01-01',
            'Día Internacional de los Trabajadores' => '05-01',
            'Día de Independencia' => '09-16',
            'Cambio de Gobierno' => '10-01',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $constitutionDay = (new CarbonImmutable("first monday of february $year")) // 5 of february
        ->setTimezone('America/Mexico_City');

        $benitoJuarezBirth = (new CarbonImmutable("third monday of March $year")) // 21 of march
        ->setTimezone('America/Mexico_City');

        $revolutionDay = (new CarbonImmutable("third monday of november $year")) // 20 of november
        ->setTimezone('America/Mexico_City');

        /** @var CarbonImmutable|false $executiveChange */
        $executiveChange = $this->governmentChangeDate();

        $known_days = [
            'Día de la Constitución' => $constitutionDay, // It's the first monday of february
            'Natalicio de Benito Juárez' => $benitoJuarezBirth,
            'Día de la Revolución' => $revolutionDay,
        ];

        return array_merge(
            $known_days,
            $executiveChange ? ['Cambio de Gobierno' => $executiveChange] : []
        );
    }

    protected function governmentChangeDate(): CarbonImmutable|false
    {
        $baseYear = 1946; // The first occurrence with president Miguel Aleman Valdes
        $currentYear = CarbonImmutable::now()->year; // Get the current year

        // Check if the current year is a transmission year
        if (($currentYear - $baseYear) % 6 == 0) {
            /** @phpstan-ignore-next-line */
            return CarbonImmutable::create($currentYear, 10, 1) // October 1st of the transmission year
            ->setTimezone('America/Mexico_City');

        }
        return false;
    }

}
