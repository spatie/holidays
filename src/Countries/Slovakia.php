<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Slovakia extends Country
{
    public function countryCode(): string
    {
        return 'sk';
    }

    protected function allHolidays(int $year): array
    {
        $holidays = array_merge([
            Holiday::national('Deň vzniku Slovenskej republiky', "{$year}-01-01"),
            Holiday::national('Zjavenie Pána (Traja králi)', "{$year}-01-06"),
            Holiday::national('Sviatok práce', "{$year}-05-01"),
            Holiday::national('Deň víťazstva nad fašizmom', "{$year}-05-08"),
            Holiday::national('Sviatok svätého Cyrila a Metoda', "{$year}-07-05"),
            Holiday::national('Výročie Slovenského národného povstania', "{$year}-08-29"),
            Holiday::national('Sedembolestná Panna Mária', "{$year}-09-15"),
            Holiday::national('Sviatok všetkých svätých', "{$year}-11-01"),
            Holiday::national('Deň boja za slobodu a demokraciu', "{$year}-11-17"),
            Holiday::national('Štedrý deň', "{$year}-12-24"),
            Holiday::national('Prvý sviatok vianočný', "{$year}-12-25"),
            Holiday::national('Druhý sviatok vianočný', "{$year}-12-26"),
        ], $this->variableHolidays($year));

        if ($year === 2018) {
            $holidays[] = Holiday::national('Výročie Deklarácie slovenského národa', "{$year}-10-30");
        }

        if ($year < 2024) {
            $holidays[] = Holiday::national('Deň Ústavy Slovenskej republiky', "{$year}-09-01");
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Veľkonočný pondelok', $easter->addDay()),
            Holiday::national('Veľký piatok', $easter->subDays(2)),
        ];
    }
}
