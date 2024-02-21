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
        return array_merge([
            'Deň vzniku Slovenskej republiky' => '01-01',
            'Zjavenie Pána (Traja králi)' => '01-06',
            'Sviatok práce' => '05-01',
            'Deň víťazstva nad fašizmom' => '05-08',
            'Sviatok svätého Cyrila a Metoda' => '07-05',
            'Výročie Slovenského národného povstania' => '08-29',
            'Deň Ústavy Slovenskej republiky' => '09-01',
            'Sedembolestná Panna Mária' => '09-15',
            'Sviatok všetkých svätých' => '11-01',
            'Deň boja za slobodu a demokraciu' => '11-17',
            'Štedrý deň' => '12-24',
            'Prvý sviatok vianočný' => '12-25',
            'Druhý sviatok vianočný' => '12-26',
        ], $this->variableHolidays($year));
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
