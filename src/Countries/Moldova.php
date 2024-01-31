<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Moldova extends Country
{
    public function countryCode(): string
    {
        return 'md';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Anul Nou' => '01-01',
            'Crăciunul pe stil vechi' => '01-07',
            'A doua zi de Crăciun pe stil vechi' => '01-08',
            'Ziua Internațională a Femeii' => '03-08',
            'Ziua Muncii' => '05-01',
            'Ziua Europei' => '05-09',
            'Ziua Internațională a Copilului' => '06-01',
            'Ziua Independenței' => '08-27',
            'Ziua Limbii Române' => '08-31',
            'Crăciunul pe stil nou' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            'Prima zi de Paște' => $easter,
            'A doua zi de Paște' => $easter->addDay(),
            'Paștele Blajinilor' => $easter->addDays(8),
        ];
    }
}
