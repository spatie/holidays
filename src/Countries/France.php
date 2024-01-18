<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class France extends Country
{
    public function countryCode(): string
    {
        return 'fr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Jour de l\'An' => '01-01',
            'Fête du Travail' => '05-01',
            'Victoire 1945' => '05-08',
            'Fête Nationale' => '07-14',
            'Assomption' => '08-15',
            'Toussaint' => '11-01',
            'Armistice 1918' => '11-11',
            'Noël' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Paris');

        return [
            'Lundi de Pâques' => $easter->addDay(),
            'Ascension' => $easter->addDays(39),
            'Lundi de Pentecôte' => $easter->addDays(50),
        ];
    }
}
