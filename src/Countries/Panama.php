<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Panama extends Country
{
    public function countryCode(): string
    {
        return 'pa';
    }

    /*
     * Source: https://www.telemetro.com/nacionales/calendario-feriados-panama-2024-todos-los-dias-no-laborables-y-festivos-n5953115
     */
    protected function allHolidays(int $year): array
    {
        $fixedHolidays = [
            'Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Día de los Mártires' => CarbonImmutable::createFromDate($year, 1, 9),
            'Día del Trabajador' => CarbonImmutable::createFromDate($year, 5, 1),
            'Separación de Panamá de Colombia' => CarbonImmutable::createFromDate($year, 11, 3),
            'Día de los Símbolos Patrios' => CarbonImmutable::createFromDate($year, 11, 4),
            'Día de Consolidación de la Separación de Panamá con Colombia en Colón' => CarbonImmutable::createFromDate($year, 11, 5),
            'Grito de la Independencia' => CarbonImmutable::createFromDate($year, 11, 10),
            'Independencia de Panamá de España' => CarbonImmutable::createFromDate($year, 11, 28),
            'Día de las Madres' => CarbonImmutable::createFromDate($year, 12, 8),
            'Día de los Caídos por la invasión de Estados Unidos a Panamá' => CarbonImmutable::createFromDate($year, 12, 20),
            'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
        ];

        return array_merge(
            $fixedHolidays,
            $this->variableHolidays($year),
            $this->calculateBridgeDays($fixedHolidays),
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Carnaval (Día 1)' => $easter->subDays(50),
            'Carnaval (Día 2)' => $easter->subDays(49),
            'Carnaval (Día 3)' => $easter->subDays(48),
            'Carnaval (Día 4)' => $easter->subDays(47),
            'Jueves Santo' => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
            'Sábado de Gloria' => $easter->subDays(1),
        ];
    }

    /**
     * Calculate bridge days for holidays that fall on a Sunday.
     * In Panama, these are called "puentes"
     *
     * Source: https://www.telemetro.com/nacionales/calendario-dias-libres-panama-este-2023-n5825178
     *
     * Spanish:
     * "Según el artículo 47 del código de trabajo un día es considerado puente cuando la fecha
     * establecida para una celebración nacional coincida con un día domingo, el lunes siguiente
     * se habilitará como día de descanso semanal obligatorio"
     *
     * English Translation:
     * "According to article 47 of the labor code, a day is considered a bridge when the date
     *  established for a national celebration to coincide with a Sunday, the following Monday
     *  will be enabled as a mandatory weekly rest day"
     *
     * @param  array<string, CarbonImmutable>  $fixedHolidays
     * @return array<string, CarbonImmutable>
     */
    protected function calculateBridgeDays(array $fixedHolidays): array
    {
        $holidays = [];

        foreach ($fixedHolidays as $name => $date) {
            $holiday = $date;

            $holidays[$name] = $holiday;

            if ($holiday->isSunday()) {
                $holidays["{$name} (Puente)"] = $holiday->addDay();
            }
        }

        return $holidays;
    }
}
