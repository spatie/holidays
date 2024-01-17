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

        $natalicioBenitoJuarez = new CarbonImmutable(sprintf("third monday of march %s", $year));
        $promulgacionConstitucion = new CarbonImmutable(sprintf("first monday of february %s", $year));
        $revolucionMexicana = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-11-20")->setTimezone('America/Mexico_City');

        if ($revolucionMexicana->isSunday()) {
            $revolucionMexicana = $revolucionMexicana->next('monday');
        }

        $mandatory = [
            'Año nuevo' => '01-01',
            'Aniversario de la promulgación de la Constitución de 1917' => $promulgacionConstitucion->format('m-d'),
            'Natalicio de Benito Juárez' => $natalicioBenitoJuarez->format('m-d'),
            'Día del Trabajo' => '05-01',
            'Día de la Independencia' => '09-15',
            'Revolución Mexicana' => $revolucionMexicana->format('m-d'),
            'Navidad' => '12-25',
        ];

        if ($this->transmisionPoderEjecutivoFederal($year)) {
            $mandatory[
                "Transmisión del Poder Ejecutivo Federal"
            ] = $this->transmisionPoderEjecutivoFederal($year);
        }

        return array_merge($mandatory, $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {

        $fathersDay = new CarbonImmutable(sprintf("third sunday of june %s", $year));

        return [

            'Día de la Candelaria' => '02-02',
            'Día de la Bandera' => '02-24',
            'Día del Niño' => '04-30',
            'Día de la Madre' => '04-30',
            'Día del Padre' => $fathersDay,
            'Día de la Raza' => '10-12',
            'Día de Muertos' => '11-02',
            'Virgen de Guadalupe' => '12-12',
        ];
    }


    protected function transmisionPoderEjecutivoFederal($year)
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
