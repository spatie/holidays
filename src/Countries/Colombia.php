<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class Colombia extends Country
{
    public function countryCode(): string
    {
        return 'co';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Año Nuevo', "{$year}-01-01"),
            Holiday::national('Día del Trabajo', "{$year}-05-01"),
            Holiday::national('Día de la independencia', "{$year}-07-20"),
            Holiday::national('Batalla de Boyacá', "{$year}-08-07"),
            Holiday::national('Inmaculada Concepción', "{$year}-12-08"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Jueves Santo', $easter->subDays(3)),
            Holiday::national('Viernes Santo', $easter->subDays(2)),
            Holiday::national('Ascención de Jesús', $easter->addDays(43)),
            Holiday::national('Corpus Christi', $easter->addDays(64)),
            Holiday::national('Sagrado corazón de Jesús', $easter->addDays(71)),
            Holiday::national('Reyes Magos', $this->emilianiHoliday($year, 1, 6)),
            Holiday::national('Día de San José', $this->emilianiHoliday($year, 3, 19)),
            Holiday::national('San Pedro y San Pablo', $this->emilianiHoliday($year, 6, 29)),
            Holiday::national('Asunción de la Virgen', $this->emilianiHoliday($year, 8, 15)),
            Holiday::national('Día de la raza', $this->emilianiHoliday($year, 10, 12)),
            Holiday::national('Todos los santos', $this->emilianiHoliday($year, 11, 1)),
            Holiday::national('Independencia de Cartagena', $this->emilianiHoliday($year, 11, 11)),
        ];
    }

    private function emilianiHoliday(int $year, int $month, int $day): CarbonImmutable
    {
        $dateObj = CarbonImmutable::createFromDate($year, $month, $day, 'America/Bogota')->startOfDay();

        if ($dateObj->is('Monday')) {
            return $dateObj;
        }

        return $dateObj->next('Monday')->toImmutable();
    }
}
