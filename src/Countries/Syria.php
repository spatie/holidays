<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Syria extends Country
{
    public function countryCode(): string
    {
        return 'sy';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Mother\'s Day' => '03-21',
            'Teacher\'s Day' => '03-21',
            'Western Easter' => '03-31',
            'Eid al-Fitr' => '04-10',
            'Syrian Independence Day' => '04-17',
            'Labor Day' => '05-01',
            'Eastern Easter' => '05-05',
            'Martyrs\'s Day' => '05-06',
            'Eid al-Adha' => '06-16',
            'Islamic New Year' => '07-07',
            'The commemoration of the birth of the Prophet Muhammad' => '09-15',
            'The October Liberation War' => '10-06',
            'Merry Christmas' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // The variable holidays all follow the lunar calendar, so their dates are not confirmed.
        return [];
    }
}
