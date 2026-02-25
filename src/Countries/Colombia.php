<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class Colombia extends Country
{
    public function countryCode(): string
    {
        return 'co';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día del Trabajo' => CarbonImmutable::createFromDate($year, 5, 1),
            'Día de la independencia' => CarbonImmutable::createFromDate($year, 7, 20),
            'Batalla de Boyacá' => CarbonImmutable::createFromDate($year, 8, 7),
            'Inmaculada Concepción' => CarbonImmutable::createFromDate($year, 12, 8),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonInterface> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
            'Ascención de Jesús' => $easter->addDays(43),
            'Corpus Christi' => $easter->addDays(64),
            'Sagrado corazón de Jesús' => $easter->addDays(71),
            'Reyes Magos' => $this->emilianiHoliday($year, 1, 6),
            'Día de San José' => $this->emilianiHoliday($year, 3, 19),
            'San Pedro y San Pablo' => $this->emilianiHoliday($year, 6, 29),
            'Asunción de la Virgen' => $this->emilianiHoliday($year, 8, 15),
            'Día de la raza' => $this->emilianiHoliday($year, 10, 12),
            'Todos los santos' => $this->emilianiHoliday($year, 11, 1),
            'Independencia de Cartagena' => $this->emilianiHoliday($year, 11, 11),

        ];
    }

    private function emilianiHoliday(int $year, int $month, int $day): CarbonInterface
    {
        $dateObj = CarbonImmutable::createFromDate($year, $month, $day, 'America/Bogota')->startOfDay();

        if ($dateObj->is('Monday')) {
            return $dateObj;
        }

        return $dateObj->next('Monday');
    }
}
