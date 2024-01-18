<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
class Tunisia extends Country
{
    public function countryCode(): string
    {
        return 'tn';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => CarbonImmutable::createFromDate($year, 1, 1),
            'Independence Day' => CarbonImmutable::createFromDate($year, 3, 20),
            'Martyrs\' Day' => CarbonImmutable::createFromDate($year, 4, 9),
            'Labour Day' => CarbonImmutable::createFromDate($year, 5, 1),
            'Republic Day' => CarbonImmutable::createFromDate($year, 7, 25),
            'Women\'s Day' => CarbonImmutable::createFromDate($year, 8, 13),
            'Evacuation Day' => CarbonImmutable::createFromDate($year, 10, 15),
            'Revolution and Youth Day' => CarbonImmutable::createFromDate($year, 12, 17),
        ], $this->variableHolidays($year));
    }

    /**
     * The following holidays are considered public holidays in Tunisia. However, their dates vary each year,
     * as they are based on the Islamic Hijri (lunar) calendar. These holidays do not have a fixed date and
     * occur based on the lunar calendar sequence. The order listed reflects the chronological occurrence
     * of these holidays throughout the year.
     */
    protected function variableHolidays(int $year): array
    {
        return [
            'Eid al-Fitr' => '04-10',
            'Eid al-Fitr 2' => '04-11',
            'Eid al-Adha' => '06-16',
            'Eid al-Adha 2' => '06-17',
            'Islamic New Year' => '07-07',
            'Birthday of the Prophet Muhammad' => '09-16'
        ];
    }
}
