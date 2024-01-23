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
            'Año Nuevo' => '01-01',
            'Día de los Mártires' => '01-09',
            'Día del Trabajador' => '05-01',
            'Separación de Panamá de Colombia' => '11-03',
            'Día de los Símbolos Patrios' => '11-04',
            'Día de Consolidación de la Separación de Panamá con Colombia en Colón' => '11-05',
            'Grito de la Independencia' => '11-10',
            'Independencia de Panamá de España' => '11-28',
            'Día de las Madres' => '12-08',
            'Día de los Caídos por la invasión de Estados Unidos a Panamá' => '12-20',
            'Navidad' => '12-25',
        ];

        return array_merge(
            $fixedHolidays,
            $this->variableHolidays($year),
            $this->calculateBridgeDays($fixedHolidays, $year),
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
     * @param  array<string, string>  $fixedHolidays  Array of holidays in the format ['holiday name' => 'mm-dd']
     * @param  int  $year  The year for which to calculate the holidays
     * @return array<string, CarbonImmutable>
     */
    protected function calculateBridgeDays(array $fixedHolidays, int $year): array
    {
        $holidays = [];

        foreach ($fixedHolidays as $name => $date) {
            $holiday = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}");

            if ($holiday !== false) {
                $holidays[$name] = $holiday;
                if ($holiday->isSunday()) {
                    $holidays[$name.' (Puente)'] = $holiday->addDay();
                }
            }
        }

        return $holidays;
    }
}
