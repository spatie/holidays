<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use GeniusTS\HijriDate\Hijri;

class Bahrain extends Country
{
    public function countryCode(): string
    {
        return 'bh';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year Day' => CarbonImmutable::createFromDate($year, 1, 1),
            'Labour Day' => CarbonImmutable::createFromDate($year, 5, 1),
            'Ashura Holiday 1' => CarbonImmutable::createFromDate($year, 7, 16),
            'Ashura Holiday 2' => CarbonImmutable::createFromDate($year, 7, 17),
            'National Day' => CarbonImmutable::createFromDate($year, 12, 16),
            'National Day Holiday' => CarbonImmutable::createFromDate($year, 12, 17),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [
            'Islamic new year' => $this->getHijriDateAsGregorian(1, 1, $year + 1),
            'Prophet Muhammads Birthday' =>  $this->getHijriDateAsGregorian(12, 3, $year + 1),
            'Eid al-Fitr Holiday 1' =>  $this->getHijriDateAsGregorian(1, 10, $year, 1),
            'Eid al-Fitr Holiday 2' =>  $this->getHijriDateAsGregorian(2, 10, $year, 1),
            'Eid al-Fitr Holiday 3' =>  $this->getHijriDateAsGregorian(3, 10, $year, 1),
            'Eid al Adha Holiday 1' =>  $this->getHijriDateAsGregorian(10, 12, $year, 1),
            'Eid al Adha Holiday 2' =>  $this->getHijriDateAsGregorian(11, 12, $year, 1),
            'Eid al Adha Holiday 3' =>  $this->getHijriDateAsGregorian(12, 12, $year, 1),
        ];
    }

    /**
     * Convert Hijri dates to Gregorian
     * @param int $hijriDay
     * @param int $hijriMonth
     * @param int $hijriYear
     * @param int $adjustmentDays
     * @return CarbonImmutable
     */
    protected function getHijriDateAsGregorian(
        int $hijriDay,
        int $hijriMonth,
        int $hijriYear,
        int $adjustmentDays = 0
    ): CarbonImmutable {
        $gregorianNewYear = CarbonImmutable::create($hijriYear, 1, 1);
        $hijriNewYear = Hijri::convertToHijri($gregorianNewYear);
        $gregorianDate = Hijri::convertToGregorian($hijriDay, $hijriMonth, $hijriNewYear->year);
        return CarbonImmutable::instance($gregorianDate)->addDays($adjustmentDays);
    }
}
