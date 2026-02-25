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
            'Novo leto' => CarbonImmutable::createFromDate($year, 1, 1), // New Year's Day
            'Novo leto 2' => CarbonImmutable::createFromDate($year, 1, 2), // New Year's Day, yes it's a second day
            'Prešernov dan, slovenski kulturni praznik' => CarbonImmutable::createFromDate($year, 2, 8), // Prešeren Day, Slovenian Cultural Holiday
            'Dan upora proti okupatorju' => CarbonImmutable::createFromDate($year, 4, 27), // Day of Uprising Against Occupation
            'Praznik dela' => CarbonImmutable::createFromDate($year, 5, 1),  // Labour Day
            'Praznik dela 2' => CarbonImmutable::createFromDate($year, 5, 2), // Labour Day, yes it's a second day
            'Dan državnosti' => CarbonImmutable::createFromDate($year, 6, 25), // Statehood Day
            'Marijino vnebovzetje' => CarbonImmutable::createFromDate($year, 8, 15), // Assumption of Mary
            'Dan reformacije' => CarbonImmutable::createFromDate($year, 10, 31), // Reformation Day
            'Dan spomina na mrtve' => CarbonImmutable::createFromDate($year, 11, 1), // Remembrance Day
            'Božič' => CarbonImmutable::createFromDate($year, 12, 25), // Christmas Day
            'Dan samostojnosti in enotnosti' => CarbonImmutable::createFromDate($year, 12, 26), // Independence and Unity Day
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Velikonočna nedelja' => $easter, // Easter Sunday
            'Velikonočni ponedeljek' => $easter->addDay(), // Easter Monday
            'Binkoštna nedelja' => $easter->addDays(49), // Whit Sunday
        ];
    }
}
