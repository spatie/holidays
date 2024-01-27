<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use GeniusTS\HijriDate\Hijri;

trait HijriCalendar
{
    /**
     * Converts a Hijri date to a Gregorian date with a possible adjustment.
     *
     * @param int $hijriDay
     * @param int $hijriMonth
     * @param int $hijriYear
     * @param int $adjustmentDays Number of days to adjust the Hijri date by.
     * @return CarbonImmutable
     */
    protected function getHijriDateAsGregorian(int $hijriDay, int $hijriMonth, int $hijriYear, int $adjustmentDays = 0): CarbonImmutable
    {
        $hijriYear = $this->convertToHijriYear($hijriYear);
        $gregorianDate = Hijri::convertToGregorian($hijriDay, $hijriMonth, $hijriYear);
        return CarbonImmutable::instance($gregorianDate)->addDays($adjustmentDays);
    }

    /**
     * Convert Gregorian year to Hijri year
     *
     * @param int $year
     *
     * @return int
     */
    protected function convertToHijriYear(int $year): int
    {
        $gregorianNewYear = CarbonImmutable::create($year, 1, 1);
        $hijriNewYear = Hijri::convertToHijri($gregorianNewYear);
        $hijriYear = $hijriNewYear->year;

        return $hijriYear;
    }
}
