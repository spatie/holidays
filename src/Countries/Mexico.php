<?php

namespace Spatie\Holidays\Countries;

use Carbon\Carbon;
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
            'Natalicio de Benito Juárez' => '04-18',
            'Día Internacional de los Trabajadores' => '05-01',
            'Jornada Electoral General' => '06-02',
            'Día de Independencia' => '09-16',
            'Cambio de Gobierno' => '10-01',
            'Día de la Revolución' => '11-18',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        /** @phpstan-ignore-next-line */
        $constitutionDay = Carbon::createFromFormat("d/m/Y", "01/02/" . $year)
            ->firstOfMonth(1)
            ->setTimezone('America/Mexico_City');

        return [
            'Día de la Constitución' => CarbonImmutable::createFromMutable($constitutionDay) // It's the first monday of february
        ];
    }
}
