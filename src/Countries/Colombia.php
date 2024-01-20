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
            'Día de la Inmaculada Concepción' => '12-08',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('America/Bogota');

        return [
            'Día de los Reyes Magos' => $this->movableHoliday(CarbonImmutable::createFromDate($year, 1, 6)),
            'Día de San José' => $this->movableHoliday(CarbonImmutable::createFromDate($year, 3, 19)),
            'San Pedro y San Pablo' => $this->movableHoliday(CarbonImmutable::createFromDate($year, 6, 29)),
            'Asunción de la Virgen' => $this->movableHoliday(CarbonImmutable::createFromDate($year, 8, 15)),
            'Día de la raza' => $this->movableHoliday(CarbonImmutable::createFromDate($year, 10, 12)),
            'Todos los santos' => $this->movableHoliday(CarbonImmutable::createFromDate($year, 11, 1)),
            'Independencia de Cartagena' => $this->movableHoliday(CarbonImmutable::createFromDate($year, 11, 11)),
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
            'Ascención del Señor' => $easter->addDays(43),
            'Corpus Christi' => $easter->addDays(64),
            'Sagrado corazón de Jesús' => $easter->addDays(71),

        ];
    }

    /** @return CarbonImmutable */
    private function movableHoliday(CarbonImmutable $date): CarbonImmutable
    {
        return $date->is('Monday')
            ? $date
            : $date->next('Monday');
    }
}
