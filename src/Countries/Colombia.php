<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Colombia extends Country
{
    public function countryCode(): string
    {
        return 'co';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => '01-01',
            'Día del Trabajo' => '05-01',
            'Día de la independencia' => '07-20',
            'Batalla de Boyacá' => '08-07',
            'Inmaculada Concepción' => '12-08',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
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

    private function emilianiHoliday(int $year, int $month, int $day): CarbonImmutable
    {
        $dateObj = CarbonImmutable::createFromDate($year, $month, $day, 'America/Bogota')->startOfDay();
        if ($dateObj->is('Monday')) {
            return $dateObj;
        } else {
            return $dateObj->next('Monday');
        }
    }
}
