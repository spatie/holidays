<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Poland extends Country
{
    public function countryCode(): string
    {
        return 'pl';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nowy Rok' => '01-01',
            'Święto Trzech Króli' => '01-06',
            'Święto Pracy' => '05-01',
            'Święto Konstytucji 3 Maja' => '05-03',
            'Święto Wojska Polskiego, Wniebowzięcie Najświętszej Maryi Panny' => '08-15',
            'Wszystkich Świętych' => '11-01',
            'Święto Niepodległości' => '11-11',
            'Boże Narodzenie' => '12-25',
            'Drugi Dzień Bożego Narodzenia' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Wielkanoc' => $easter,
            'Poniedziałek Wielkanocny' => $easter->addDay(),
            'Zielone Świątki' => $easter->addWeeks(7),
            'Boże Ciało' => $easter->addDays(60),
        ];
    }
}
