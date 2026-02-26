<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Holiday;

class Morocco extends Country
{
    public function countryCode(): string
    {
        return 'ma';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national('Proclamation of Independence Day', "{$year}-01-11"),
            Holiday::national('Amazigh New Year (ⵉⴹ ⵏ ⵢⵉⵏⵏⴰⵢⵔ)', "{$year}-01-14"),
            Holiday::national('Labour Day', "{$year}-05-01"),
            Holiday::national('Throne Day', "{$year}-07-30"),
            Holiday::national('Oued Ed-Dahab Day', "{$year}-08-14"),
            Holiday::national('Revolution Day', "{$year}-08-20"),
            Holiday::national('Youth Day', "{$year}-08-21"),
            Holiday::national('Green March', "{$year}-11-06"),
            Holiday::national('Independence Day', "{$year}-11-18"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        // Calculate the current Hijri year based on the Gregorian year
        $currentHijriYear = 1444 + ($year - 2022);

        /**
         * The following holidays are considered public holidays in Morocco. However, their dates vary each year,
         * as they are based on the Islamic Hijri (lunar) calendar. These holidays do not have a fixed date and
         * occur based on the lunar calendar sequence. The order listed reflects the chronological occurrence
         * of these holidays throughout the year.
         */

        // Define Islamic holidays on the Hijri calendar
        $islamicHolidaysOnHijri = [
            'Islamic New Year' => '01-01',
            'Birthday of the Prophet Muhammad' => '03-12',
            'Birthday of the Prophet Muhammad 2' => '03-13',
            'Eid al-Fitr' => '10-01',
            'Eid al-Fitr 2' => '10-02',
            'Eid al-Adha' => '12-10',
            'Eid al-Adha 2' => '12-11',
        ];

        $holidays = [];

        foreach ($islamicHolidaysOnHijri as $holidayTitle => $hijriHolidayDate) {
            [$hijriHolidayMonth, $hijriHolidayDay] = explode('-', $hijriHolidayDate);

            $GregorianDate = $this->islamicToGregorian($currentHijriYear, (int) $hijriHolidayMonth, (int) $hijriHolidayDay);
            $vlideYear = $GregorianDate['year'];
            $tempCurrentHijriYear = $currentHijriYear;

            while ($vlideYear != $year) {
                $GregorianDate = $this->islamicToGregorian($tempCurrentHijriYear--, (int) $hijriHolidayMonth, (int) $hijriHolidayDay);
                $vlideYear = $GregorianDate['year'];

                if ($vlideYear < 1976) {
                    throw InvalidYear::range($this->countryCode(), 1976, $year);
                }
            }

            $holidays[] = Holiday::national($holidayTitle, sprintf('%s-%s-%s', $GregorianDate['year'], $GregorianDate['month'], $GregorianDate['day']));
        }

        return $holidays;
    }

    /**
     * Converts a Hijri date to the corresponding Gregorian date.
     * This function is adapted from the conversion tool used on the Moroccan
     * Minister of Endowments and Islamic Affairs official website.
     * https://www.habous.gov.ma/محول-التاريخ
     *
     * @param  int  $y  The Hijri year.
     * @param  int  $m  The Hijri month.
     * @param  int  $d  The Hijri day.
     * @return array{year: int, month: int, day: int} An array containing the corresponding Gregorian date in the format ['year' => YYYY, 'month' => MM, 'day' => DD].
     */
    private function islamicToGregorian(int $y, int $m, int $d): array
    {
        $jd = $this->intPart((11 * $y + 3) / 30) + 354 * $y + 30 * $m - $this->intPart(($m - 1) / 2) + $d + 1948440 - 385;
        if ($jd > 2299160) {
            $l = $jd + 68569;
            $n = $this->intPart((4 * $l) / 146097);
            $l = $l - $this->intPart((146097 * $n + 3) / 4);
            $i = $this->intPart((4000 * ($l + 1)) / 1461001);
            $l = $l - $this->intPart((1461 * $i) / 4) + 31;
            $j = $this->intPart((80 * $l) / 2447);
            $d = $l - $this->intPart((2447 * $j) / 80);
            $l = $this->intPart($j / 11);
            $m = $j + 2 - 12 * $l;
            $y = 100 * ($n - 49) + $i + $l;
        } else {
            $j = $jd + 1402;
            $k = $this->intPart(($j - 1) / 1461);
            $l = $j - 1461 * $k;
            $n = $this->intPart(($l - 1) / 365) - $this->intPart($l / 1461);
            $i = $l - 365 * $n + 30;
            $j = $this->intPart((80 * $i) / 2447);
            $d = $i - $this->intPart((2447 * $j) / 80);
            $i = $this->intPart($j / 11);
            $m = $j + 2 - 12 * $i;
            $y = 4 * $k + $n + $i - 4716;
        }

        return [
            'year' => (int) $y,
            'month' => (int) $m,
            'day' => (int) $d,
        ];
    }

    /**
     * Rounds a floating-point number to the nearest integer.
     * If the floating-point number is negative, it uses ceil function.
     * If the floating-point number is positive, it uses floor function.
     *
     * @param  float  $floatNum  The floating-point number to be rounded.
     * @return float The rounded integer value.
     */
    private function intPart(int|float $floatNum): float
    {
        // Check if the floating-point number is negative
        if ($floatNum < -0.0000001) {
            // If negative, round up using ceil
            return ceil($floatNum - 0.0000001);
        }

        // If positive or zero, round down using floor
        return floor($floatNum + 0.0000001);
    }
}
