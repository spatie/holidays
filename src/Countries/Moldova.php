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
            'Anul Nou' => CarbonImmutable::createFromDate($year, 1, 1),
            'Crăciunul pe stil vechi' => CarbonImmutable::createFromDate($year, 1, 7),
            'A doua zi de Crăciun pe stil vechi' => CarbonImmutable::createFromDate($year, 1, 8),
            'Ziua Internațională a Femeii' => CarbonImmutable::createFromDate($year, 3, 8),
            'Ziua Muncii' => CarbonImmutable::createFromDate($year, 5, 1),
            'Ziua Europei' => CarbonImmutable::createFromDate($year, 5, 9),
            'Ziua Internațională a Copilului' => CarbonImmutable::createFromDate($year, 6, 1),
            'Ziua Independenței' => CarbonImmutable::createFromDate($year, 8, 27),
            'Ziua Limbii Române' => CarbonImmutable::createFromDate($year, 8, 31),
            'Crăciunul pe stil nou' => CarbonImmutable::createFromDate($year, 12, 25),
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
