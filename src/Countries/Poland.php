<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Poland extends Country
{
    public function countryCode(): string
    {
        return 'pl';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Nowy Rok', "{$year}-01-01"),
            Holiday::national('Święto Trzech Króli', "{$year}-01-06"),
            Holiday::national('Święto Pracy', "{$year}-05-01"),
            Holiday::national('Święto Konstytucji 3 Maja', "{$year}-05-03"),
            Holiday::national('Święto Wojska Polskiego, Wniebowzięcie Najświętszej Maryi Panny', "{$year}-08-15"),
            Holiday::national('Wszystkich Świętych', "{$year}-11-01"),
            Holiday::national('Święto Niepodległości', "{$year}-11-11"),
            Holiday::national('Boże Narodzenie', "{$year}-12-25"),
            Holiday::national('Drugi Dzień Bożego Narodzenia', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $variableHolidays = [
            Holiday::national('Wielkanoc', $easter),
            Holiday::national('Poniedziałek Wielkanocny', $easter->addDay()),
            Holiday::national('Zielone Świątki', $easter->addWeeks(7)),
            Holiday::national('Boże Ciało', $easter->addDays(60)),
        ];

        if ($year >= 2025) {
            $variableHolidays[] = Holiday::national('wigilii Bożego Narodzenia', "{$year}-12-24");
        }

        return $variableHolidays;
    }
}
