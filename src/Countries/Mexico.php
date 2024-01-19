<?php

namespace Spatie\Holidays\Countries;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

class Netherlands extends Country
{
    public function countryCode(): string
    {
        return 'mx';
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año nuevo' => '01-01',
            'Día de la Candelaria' => '02-02',
            'Día de la Bandera' => '02-24',
            'Día del Niño' => '04-30',
            'Día de la Madre' => '05-10',
            'Día del Trabajo' => '05-01',
            'Día de la Independencia' => '09-16',
            'Día de la Raza' => '10-12',
            'Día de Muertos' => '11-02',
            'Virgen de Guadalupe' => '12-12',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {

        $natalicioBenitoJuarez = new CarbonImmutable(sprintf("third monday of march %s", $year));
        $promulgacionConstitucion = new CarbonImmutable(sprintf("first monday of february %s", $year));
        $revolucionMexicana = new CarbonImmutable(sprintf("third monday of november %s", $year));

        $fathersDay = new CarbonImmutable(sprintf("third sunday of june %s", $year));


        $days = [
            'Aniversario de la promulgación de la Constitución de 1917' => $promulgacionConstitucion->format('m-d'),
            'Natalicio de Benito Juárez' => $natalicioBenitoJuarez->format('m-d'),
            'Revolución Mexicana' => $revolucionMexicana->format('m-d'),
            'Día del Padre' => $fathersDay->format('m-d'),

        ];

        if ($this->transmisionPoderEjecutivoFederal($year)) {
            $days[
                "Transmisión del Poder Ejecutivo Federal"
            ] = $this->transmisionPoderEjecutivoFederal($year);
        }

        return $days;
    }


    protected function transmisionPoderEjecutivoFederal($year): bool|string
    {
        $period = new CarbonPeriod();
        $period->setDateClass(CarbonImmutable::class);
        $period
            ->every("6 years")
            ->since(sprintf("%s-10-01", 2024))
            ->until(sprintf("%s-10-01 00:00:00", Carbon::now()->addYears(6)->year));

        $period->addFilter(function ($date) use ($year) {
            return $date->year === $year;
        });

        $availableDates = $period->toArray();

        if (count($availableDates)) {
            return $availableDates[0]->format("m-d");
        }
        return false;
    }
}
