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
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('America/Bogota');

        return [
            'Reyes Magos' => $this->emilianiHoliday(CarbonImmutable::createFromFormat('Y-m-d', $year . '-01-06')),
            'Día de San José' => $this->emilianiHoliday(CarbonImmutable::createFromFormat('Y-m-d', $year . '-03-19')),
            'San Pedro y San Pablo' => $this->emilianiHoliday(CarbonImmutable::createFromFormat('Y-m-d', $year . '-06-29')),
            'Asunción de la Virgen' => $this->emilianiHoliday(CarbonImmutable::createFromFormat('Y-m-d', $year . '-08-15')),
            'Día de la raza' => $this->emilianiHoliday(CarbonImmutable::createFromFormat('Y-m-d', $year . '-10-12')),
            'Todos los santos' => $this->emilianiHoliday(CarbonImmutable::createFromFormat('Y-m-d', $year . '-11-01')),
            'Independencia de Cartagena' => $this->emilianiHoliday(CarbonImmutable::createFromFormat('Y-m-d', $year . '-11-11')),
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
            'Ascención de Jesús' => $easter->addDays(43),
            'Corpus Christi' => $easter->addDays(64),
            'Sagrado corazón de Jesús' => $easter->addDays(71),

        ];
    }

    /** @return CarbonImmutable */
    private function emilianiHoliday(CarbonImmutable $date): CarbonImmutable
    {
        if ($date->is('Monday')) {
            return $date;
        } else {
            return $date->next('Monday');
        }
    }
}
