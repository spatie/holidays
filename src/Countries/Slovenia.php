<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Slovenia extends Country
{
    public function countryCode(): string
    {
        return 'si';
    }

    protected function allHolidays(int $year): array
    {

        return array_merge([
            'Novo leto' => '01-01', // New Year's Day
            'Novo leto 2' => '01-02', // New Year's Day, yes it's a second day
            'Prešernov dan, slovenski kulturni praznik' => '08-02', // Prešeren Day, Slovenian Cultural Holiday
            'Dan upora proti okupatorju' => '04-27', // Day of Uprising Against Occupation
            'Praznik dela' => '05-01',  // Labour Day
            'Praznik dela 2' => '05-02', // Labour Day, yes it's a second day
            'Dan državnosti' => '06-25', // Statehood Day
            'Marijino vnebovzetje' => '08-15', // Assumption of Mary
            'Dan reformacije' => '10-31', // Reformation Day
            'Dan spomina na mrtve' => '11-01', // Remembrance Day
            'Božič' => '12-25', // Christmas Day
            'Dan samostojnosti in enotnosti' => '12-26', // Independence and Unity Day
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Velikonočni ponedeljek' => $easter->addDay(), // Easter Monday
        ];
    }
}
