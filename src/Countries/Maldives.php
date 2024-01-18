<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Maldives extends Country
{
    public function countryCode(): string
    {
        return 'mv';
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Labor Day / May Day' => '05-01',
            'Independence Day' => '07-26',
            'Independence Day Holiday' => '07-27',
            'Victory Day' => '11-03',
            'Republic Day' => '11-11',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {

        return [
            'Ramadan Start' => '03-11',
            'Ramadan Holiday' => '03-31',
            'Ramadan Holiday' => '04-01',
            'Ramadan Holiday' => '04-02',
            'Ramadan Holiday' => '04-03',
            'Ramadan Holiday' => '04-04',
            'Ramadan Holiday' => '04-05',
            'Ramadan Holiday' => '04-06',
            'Ramadan Holiday' => '04-07',
            'Ramadan Holiday' => '04-08',
            'Ramadan Holiday' => '04-09',
            'Eid al-Fitr' => '04-10',
            'Eid al-Fitr 2' => '04-11',
            'Eid al-Fitr 3' => '04-12',
            'Hajj Day' => '06-16',
            'Eid al-Adha' => '06-17',
            'Eid al-Adha 2' => '06-18',
            'Eid al-Adha 3' => '06-19',
            'Eid al-Adha 4' => '06-20',
            'Islamic New Year' => '07-08',
            'National Day' => '09-05',
            'Birthday of the Prophet Muhammad' => '09-16',
            'The Day Maldives Embraced Islam' => '10-05',
        ];
    }
}
