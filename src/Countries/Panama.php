<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

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
            Holiday::national('Año Nuevo', "{$year}-01-01"),
            Holiday::national('Día de los Mártires', "{$year}-01-09"),
            Holiday::national('Día del Trabajador', "{$year}-05-01"),
            Holiday::national('Separación de Panamá de Colombia', "{$year}-11-03"),
            Holiday::national('Día de los Símbolos Patrios', "{$year}-11-04"),
            Holiday::national('Día de Consolidación de la Separación de Panamá con Colombia en Colón', "{$year}-11-05"),
            Holiday::national('Grito de la Independencia', "{$year}-11-10"),
            Holiday::national('Independencia de Panamá de España', "{$year}-11-28"),
            Holiday::national('Día de las Madres', "{$year}-12-08"),
            Holiday::national('Día de los Caídos por la invasión de Estados Unidos a Panamá', "{$year}-12-20"),
            Holiday::national('Navidad', "{$year}-12-25"),
        ];

        return array_merge(
            $fixedHolidays,
            $this->variableHolidays($year),
            $this->calculateBridgeDays($fixedHolidays),
        );
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Carnaval (Día 1)', $easter->subDays(50)),
            Holiday::national('Carnaval (Día 2)', $easter->subDays(49)),
            Holiday::national('Carnaval (Día 3)', $easter->subDays(48)),
            Holiday::national('Carnaval (Día 4)', $easter->subDays(47)),
            Holiday::national('Jueves Santo', $easter->subDays(3)),
            Holiday::national('Viernes Santo', $easter->subDays(2)),
            Holiday::national('Sábado de Gloria', $easter->subDays(1)),
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
     * @param  array<Holiday>  $fixedHolidays
     * @return array<Holiday>
     */
    protected function calculateBridgeDays(array $fixedHolidays): array
    {
        $bridgeDays = [];

        foreach ($fixedHolidays as $holiday) {
            $date = $holiday->date;

            if ($date->isSunday()) {
                $bridgeDays[] = Holiday::national($holiday->name.' (Puente)', $date->addDay());
            }
        }

        return $bridgeDays;
    }
}
