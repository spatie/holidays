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
            'Nowy Rok' => CarbonImmutable::createFromDate($year, 1, 1),
            'Święto Trzech Króli' => CarbonImmutable::createFromDate($year, 1, 6),
            'Święto Pracy' => CarbonImmutable::createFromDate($year, 5, 1),
            'Święto Konstytucji 3 Maja' => CarbonImmutable::createFromDate($year, 5, 3),
            'Święto Wojska Polskiego, Wniebowzięcie Najświętszej Maryi Panny' => CarbonImmutable::createFromDate($year, 8, 15),
            'Wszystkich Świętych' => CarbonImmutable::createFromDate($year, 11, 1),
            'Święto Niepodległości' => CarbonImmutable::createFromDate($year, 11, 11),
            'Boże Narodzenie' => CarbonImmutable::createFromDate($year, 12, 25),
            'Drugi Dzień Bożego Narodzenia' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $variableHolidays = [
            'Wielkanoc' => $easter,
            'Poniedziałek Wielkanocny' => $easter->addDay(),
            'Zielone Świątki' => $easter->addWeeks(7),
            'Boże Ciało' => $easter->addDays(60),
        ];

        if ($year >= 2025) {
            $variableHolidays = array_merge($variableHolidays, ['wigilii Bożego Narodzenia' => CarbonImmutable::createFromDate($year, 12, 24)]);
        }

        return $variableHolidays;
    }
}
