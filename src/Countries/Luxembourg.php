<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Luxembourg extends Country
{
    public function countryCode(): string
    {
        return 'lu';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nouvel An' => '01-01',
            'Premier Mai' => '05-01',
            'Journée de l\'Europe' => '05-09',
            'Fête nationale' => '06-23',
            'Assomption' => '08-15',
            'Toussaint' => '11-01',
            'Noël' => '12-25',
            'Saint Étienne' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Luxembourg');

        return [
            'Lundi de Pâques' => $easter->addDay(),
            'Ascension' => $easter->addDays(39),
            'Lundi de Pentecôte' => $easter->addDays(50),
        ];
    }
}
