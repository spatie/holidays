<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

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
            Holiday::national('Año Nuevo', "{$year}-01-01"),
            Holiday::national('Día de los Héroes', "{$year}-03-01"),
            Holiday::national('Día del Trabajador', "{$year}-05-01"),
            Holiday::national('Día de la Independencia Nacional', "{$year}-05-15"),
            Holiday::national('Fundación de Asunción', "{$year}-08-15"),
            Holiday::national('Batalla de Boquerón', "{$year}-09-29"),
            Holiday::national('Virgen de Caacupé', "{$year}-12-08"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    private function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Paz del Chaco', $this->chacoArmistice($year)),
            Holiday::national('Jueves Santo', $easter->subDays(3)),
            Holiday::national('Viernes Santo', $easter->subDays(2)),
        ];
    }

    private function chacoArmistice(int $year): CarbonImmutable
    {
        // In 2014, the Day of Chaco Armistice was moved to June 16th (Decree N.º 280 signed in September 2013)
        // For later years, the date remains as June 12th
        return CarbonImmutable::createFromDate($year, 06, $year === 2014 ? 16 : 12);
    }
}
