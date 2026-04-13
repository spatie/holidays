<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Romania extends Country
{
    public function countryCode(): string
    {
        return 'ro';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Anul Nou', "{$year}-01-01"),
            Holiday::national('A doua zi de Anul Nou', "{$year}-01-02"),
            Holiday::national('Bobotează', "{$year}-01-06"),
            Holiday::national('Sfântul Ion', "{$year}-01-07"),
            Holiday::national('Ziua Unirii Principatelor Române', "{$year}-01-24"),
            Holiday::national('Ziua Muncii', "{$year}-05-01"),
            Holiday::national('Ziua Copilului', "{$year}-06-01"),
            Holiday::national('Adormirea Maicii Domnului', "{$year}-08-15"),
            Holiday::national('Sfântul Andrei', "{$year}-11-30"),
            Holiday::national('Ziua Națională', "{$year}-12-01"),
            Holiday::national('Crăciunul', "{$year}-12-25"),
            Holiday::national('A doua zi de Crăciun', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            Holiday::national('Vinerea Mare', $easter->subDays(2)),
            Holiday::national('Paștele', $easter),
            Holiday::national('A doua zi de Paște', $easter->addDay()),
            Holiday::national('Rusaliile', $easter->addDays(49)),
            Holiday::national('A doua zi de Rusalii', $easter->addDays(50)),
        ];
    }
}
