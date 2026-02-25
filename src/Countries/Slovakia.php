<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Slovakia extends Country
{
    public function countryCode(): string
    {
        return 'sk';
    }

    protected function allHolidays(int $year): array
    {
        $holidays = array_merge([
            'Deň vzniku Slovenskej republiky' => CarbonImmutable::createFromDate($year, 1, 1),
            'Zjavenie Pána (Traja králi)' => CarbonImmutable::createFromDate($year, 1, 6),
            'Sviatok práce' => CarbonImmutable::createFromDate($year, 5, 1),
            'Deň víťazstva nad fašizmom' => CarbonImmutable::createFromDate($year, 5, 8),
            'Sviatok svätého Cyrila a Metoda' => CarbonImmutable::createFromDate($year, 7, 5),
            'Výročie Slovenského národného povstania' => CarbonImmutable::createFromDate($year, 8, 29),
            'Sedembolestná Panna Mária' => CarbonImmutable::createFromDate($year, 9, 15),
            'Sviatok všetkých svätých' => CarbonImmutable::createFromDate($year, 11, 1),
            'Deň boja za slobodu a demokraciu' => CarbonImmutable::createFromDate($year, 11, 17),
            'Štedrý deň' => CarbonImmutable::createFromDate($year, 12, 24),
            'Prvý sviatok vianočný' => CarbonImmutable::createFromDate($year, 12, 25),
            'Druhý sviatok vianočný' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));

        if ($year === 2018) {
            $holidays['Výročie Deklarácie slovenského národa'] = CarbonImmutable::createFromDate($year, 10, 30);
        }

        // Until and including the year 2023, September 1st was a public holiday.
        if ($year < 2024) {
            $holidays['Deň Ústavy Slovenskej republiky'] = CarbonImmutable::createFromDate($year, 9, 1);
        }

        return $holidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Veľkonočný pondelok' => $easter->addDay(),
            'Veľký piatok' => $easter->subDays(2),
        ];
    }
}
