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
            'Anul Nou' => '01-01',
            'A doua zi de Anul Nou' => '01-02',
            'Bobotează' => '01-06',
            'Sfântul Ion' => '01-07',
            'Ziua Unirii Principatelor Române' => '01-24',
            'Ziua Muncii' => '05-01',
            'Ziua Copilului' => '06-01',
            'Adormirea Maicii Domnului' => '08-15',
            'Sfântul Andrei' => '11-30',
            'Ziua Națională' => '12-01',
            'Crăciunul' => '12-25',
            'A doua zi de Crăciun' => '12-26',
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
