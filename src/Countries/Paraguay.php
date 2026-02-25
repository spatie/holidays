<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Paraguay extends Country
{
    public function countryCode(): string
    {
        return 'py';
    }

    protected function defaultLocale(): string
    {
        return 'es';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día de los Héroes' => CarbonImmutable::createFromDate($year, 3, 1),
            'Día del Trabajador' => CarbonImmutable::createFromDate($year, 5, 1),
            'Día de la Independencia Nacional' => CarbonImmutable::createFromDate($year, 5, 15),
            'Fundación de Asunción' => CarbonImmutable::createFromDate($year, 8, 15),
            'Batalla de Boquerón' => CarbonImmutable::createFromDate($year, 9, 29),
            'Virgen de Caacupé' => CarbonImmutable::createFromDate($year, 12, 8),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    private function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Paz del Chaco' => $this->chacoArmistice($year),
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
        ];
    }

    private function chacoArmistice(int $year): CarbonImmutable
    {
        // In 2014, the Day of Chaco Armistice was moved to June 16th (Decree N.º 280 signed in September 2013)
        // For later years, the date remains as June 12th
        return CarbonImmutable::createFromDate($year, 06, $year === 2014 ? 16 : 12);
    }
}
