<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use GeniusTS\HijriDate\Hijri;

class Tunisia extends Country
{
    private int $adjustmentDays = 1;

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
            'Islamic new year' => $this->getHijriDateAsGregorian(1, 1, $year + 1),
            'Birthday of the Prophet Muhammad' =>  $this->getHijriDateAsGregorian(12, 3, $year + 1),
            'Eid al-Fitr' =>  $this->getHijriDateAsGregorian(1, 10, $year, $this->adjustmentDays),
            'Eid al-Fitr - 2nd day' =>  $this->getHijriDateAsGregorian(2, 10, $year, $this->adjustmentDays),
            'Eid al-Adha' =>  $this->getHijriDateAsGregorian(10, 12, $year, $this->adjustmentDays),
            'Eid al-Adha - 2nd day' =>  $this->getHijriDateAsGregorian(11, 12, $year, $this->adjustmentDays),
        ];
    }

    protected function getHijriDateAsGregorian(
        int $hijriDay,
        int $hijriMonth,
        int $hijriYear,
        int $adjustmentDays = 0
    ): CarbonImmutable
    {
        $gregorianNewYear = CarbonImmutable::create($hijriYear, 1, 1);
        $hijriNewYear = Hijri::convertToHijri($gregorianNewYear);
        $gregorianDate = Hijri::convertToGregorian($hijriDay, $hijriMonth, $hijriNewYear->year);
        return CarbonImmutable::instance($gregorianDate)->addDays($adjustmentDays);
    }

}
