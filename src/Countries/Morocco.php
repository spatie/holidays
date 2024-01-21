<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use GeniusTS\HijriDate\Hijri;

class Morocco extends Country
{
    public function countryCode(): string
    {
        return 'ma';
    }

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

        // Set default adjustment for Hijri conversion
        Hijri::setDefaultAdjustment(-1);

        // Get the current Hijri year
        $currentHijriYear = (int) Hijri::convertToHijri($year . "-01-01")->format('Y');

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

        $islamicHolidaysOnGregorian = [];

        // Convert Hijri dates to Gregorian and filter based on the input year
        foreach ($islamicHolidaysOnHijri as $holidayTitle => $hijriHolidayDate) {
            list($hijriHolidayMonth, $hijriHolidayDay) = explode('-', $hijriHolidayDate);

            // Convert to Gregorian for the current and next Hijri year
            $currentGregorianDate = Hijri::convertToGregorian((int)$hijriHolidayDay, (int)$hijriHolidayMonth, (int)$currentHijriYear);
            $nextHijriYear = $currentHijriYear + 1;
            $nextGregorianDate = Hijri::convertToGregorian((int)$hijriHolidayDay, (int)$hijriHolidayMonth, (int)$nextHijriYear);

            // Check if the holiday falls in the input year
            if ($currentGregorianDate->format('Y') == $year) {
                $islamicHolidaysOnGregorian[$holidayTitle] = $currentGregorianDate->toImmutable();
            } elseif ($nextGregorianDate->format('Y') == $year) {
                $islamicHolidaysOnGregorian[$holidayTitle] = $nextGregorianDate->toImmutable();
            }
        }

        return $islamicHolidaysOnGregorian;
    }
}
