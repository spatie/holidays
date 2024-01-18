<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Morocco extends Country
{
    public function countryCode(): string
    {
        return 'ma';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Proclamation of Independence Day' => '01-11',
            'Amazigh New Year (ⵉⴹ ⵏ ⵢⵉⵏⵏⴰⵢⵔ)' => '01-14',
            'Labour Day' => '05-01',
            'Throne Day' => '07-30',
            'Oued Ed-Dahab Day' => '08-14',
            'Revolution Day' => '08-20',
            'Youth Day' => '08-21',
            'Independence Day' => '11-18',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        /**
         * The following holidays are considered public holidays in Morocco. However, their dates vary each year,
         * as they are based on the Islamic Hijri (lunar) calendar. These holidays do not have a fixed date and
         * occur based on the lunar calendar sequence. The order listed reflects the chronological occurrence
         * of these holidays throughout the year.
         */
        return [
            'Eid al-Fitr' => '04-10',
            'Eid al-Fitr 2' => '04-11',
            'Eid al-Adha' => '06-17',
            'Eid al-Adha 2' => '06-18',
            'Islamic New Year' => '07-08',
            'Birthday of the Prophet Muhammad' => '09-16',
            'Birthday of the Prophet Muhammad 2' => '09-17'
        ];
    }
}
