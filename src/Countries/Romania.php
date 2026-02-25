<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Romania extends Country
{
    public function countryCode(): string
    {
        return 'ro';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Anul Nou' => CarbonImmutable::createFromDate($year, 1, 1),
            'A doua zi de Anul Nou' => CarbonImmutable::createFromDate($year, 1, 2),
            'Bobotează' => CarbonImmutable::createFromDate($year, 1, 6),
            'Sfântul Ion' => CarbonImmutable::createFromDate($year, 1, 7),
            'Ziua Unirii Principatelor Române' => CarbonImmutable::createFromDate($year, 1, 24),
            'Ziua Muncii' => CarbonImmutable::createFromDate($year, 5, 1),
            'Ziua Copilului' => CarbonImmutable::createFromDate($year, 6, 1),
            'Adormirea Maicii Domnului' => CarbonImmutable::createFromDate($year, 8, 15),
            'Sfântul Andrei' => CarbonImmutable::createFromDate($year, 11, 30),
            'Ziua Națională' => CarbonImmutable::createFromDate($year, 12, 1),
            'Crăciunul' => CarbonImmutable::createFromDate($year, 12, 25),
            'A doua zi de Crăciun' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            'Vinerea Mare' => $easter->subDays(2),
            'Paștele' => $easter,
            'A doua zi de Paște' => $easter->addDay(),
            'Rusaliile' => $easter->addDays(49),
            'A doua zi de Rusalii' => $easter->addDays(50),
        ];
    }
}
