<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Moldova extends Country
{
    public function countryCode(): string
    {
        return 'md';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Anul Nou', "{$year}-01-01"),
            Holiday::national('Crăciunul pe stil vechi', "{$year}-01-07"),
            Holiday::national('A doua zi de Crăciun pe stil vechi', "{$year}-01-08"),
            Holiday::national('Ziua Internațională a Femeii', "{$year}-03-08"),
            Holiday::national('Ziua Muncii', "{$year}-05-01"),
            Holiday::national('Ziua Europei', "{$year}-05-09"),
            Holiday::national('Ziua Internațională a Copilului', "{$year}-06-01"),
            Holiday::national('Ziua Independenței', "{$year}-08-27"),
            Holiday::national('Ziua Limbii Române', "{$year}-08-31"),
            Holiday::national('Crăciunul pe stil nou', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            Holiday::national('Prima zi de Paște', $easter),
            Holiday::national('A doua zi de Paște', $easter->addDay()),
            Holiday::national('Paștele Blajinilor', $easter->addDays(8)),
        ];
    }
}
