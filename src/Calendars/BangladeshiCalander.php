<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Spatie\Holidays\Countries\Country;

/**
 * Handles holiday calculations for Bangladesh including:
 * - Islamic holidays (using Hijri calendar)
 * - Hindu festivals (using lunar calendar)
 * - Buddhist festivals (using lunar calendar)
 * - National holidays (using Gregorian calendar)
 * 
 * @mixin Country 
 * @property string $islamicCalendarTimezone
 */
trait BangladeshiCalander
{
    use IslamicCalendar {
        IslamicCalendar::setIslamicCalendarTimezone as private parentSetIslamicCalendarTimezone;
    }
    
    /*
    |--------------------------------------------------------------------------
    | Islamic Holiday Calculations
    |--------------------------------------------------------------------------
    */

    /** @return array<CarbonPeriod> */
    protected function shabEBarat(int $year): array
    {
        return $this->getIslamicHoliday(
            month: self::ISLAMIC_MONTHS['SHABAN'],
            day: '15',
            year: $year
        );
    }

    /** @return array<CarbonPeriod> */
    protected function shabEQadr(int $year): array
    {
        return $this->getIslamicHoliday(
            month: self::ISLAMIC_MONTHS['RAMADAN'],
            day: '27',
            year: $year
        );
    }

    /** @return array<CarbonPeriod> */
    protected function eidUlFitr(int $year): array
    {
        return $this->getIslamicHoliday(
            month: self::ISLAMIC_MONTHS['SHAWWAL'],
            day: '01',
            year: $year,
            daysBeforeAfter: [2, 2] // 2 days before and 2 days after
        );
    }

    /** @return array<CarbonPeriod> */
    protected function eidUlAdha(int $year): array
    {
        return $this->getIslamicHoliday(
            month: self::ISLAMIC_MONTHS['DHU_AL_HIJJAH'],
            day: '10',
            year: $year,
            daysBeforeAfter: [2, 3] // 2 days before and 3 days after
        );
    }

    /** @return array<CarbonPeriod> */
    protected function eideMiladunnabi(int $year): array
    {
        return $this->getIslamicHoliday(
            month: self::ISLAMIC_MONTHS['RABI_AL_AWWAL'],
            day: '12',
            year: $year
        );
    }

    /** @return array<CarbonPeriod> */
    protected function ashura(int $year): array
    {
        return $this->getIslamicHoliday(
            month: self::ISLAMIC_MONTHS['MUHARRAM'],
            day: '10',
            year: $year
        );
    }

    /** @return array<CarbonPeriod> */
    protected function shabEMeraj(int $year): array
    {
        return $this->getIslamicHoliday(
            month: self::ISLAMIC_MONTHS['RAJAB'],
            day: '27',
            year: $year
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Bengali Calendar Holiday Calculations
    |--------------------------------------------------------------------------
    */

    /** @return array<CarbonPeriod> */
    protected function pohela_boishakh(int $year): array
    {
        // Bengali New Year is typically April 14
        // Handles leap year adjustments
        $date = CarbonImmutable::create($year, 4, 14);
        if ($date->isLeapYear() && $date->month > 2) {
            $date = $date->addDay();
        }

        return [$this->createPeriod($date->format('m-d'), $year, 1)];
    }

    /*
    |--------------------------------------------------------------------------
    | Hindu and Buddhist Holiday Calculations
    |--------------------------------------------------------------------------
    */

    /** @return array<CarbonPeriod> */
    protected function buddhaPurnima(int $year): array
    {
        // Calculate first full moon day of May
        $baseDate = CarbonImmutable::create($year, 5, 1);
        $fullMoonDate = $this->findNearestFullMoon($baseDate);
        
        return [$this->createPeriod($fullMoonDate->format('m-d'), $year, 1)];
    }

    /** @return array<CarbonPeriod> */
    protected function jonmashtomi(int $year): array
    {
        // Krishna Janmashtami falls on the eighth day of the dark fortnight
        $baseDate = CarbonImmutable::create($year, 8, 15);
        $ashtamiDate = $this->calculateAshtamiDate($baseDate);
        
        return [$this->createPeriod($ashtamiDate->format('m-d'), $year, 1)];
    }

    /** @return array<CarbonPeriod> */
    protected function durgaPuja(int $year): array
    {
        // Durga Puja's main days (Ashtami and Navami)
        $baseDate = CarbonImmutable::create($year, 10, 15);
        $ashtamiDate = $this->calculateAshtamiDate($baseDate);
        
        return [$this->createPeriod($ashtamiDate->format('m-d'), $year, 2)];
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Helper method to calculate Islamic holiday dates
     * 
     * @param string $month Islamic month number
     * @param string $day Day of the month
     * @param int $year Gregorian year
     * @param array<int> $daysBeforeAfter [daysBefore, daysAfter]
     * @return array<CarbonPeriod>
     */
    private function getIslamicHoliday(
        string $month,
        string $day,
        int $year,
        array $daysBeforeAfter = [0, 0]
    ): array {
        $date = $this->islamicToGregorianDate("$month-$day", $year);
        
        if (!empty($daysBeforeAfter)) {
            $date = $date->subDays($daysBeforeAfter[0]);
            $totalDays = 1 + $daysBeforeAfter[0] + $daysBeforeAfter[1];
        } else {
            $totalDays = 1;
        }

        return [$this->createPeriod($date->format('m-d'), $year, $totalDays)];
    }

    /**
     * Calculate lunar phase (0 = new moon, 0.5 = full moon)
     */
    private function getLunarPhase(CarbonImmutable $date): float
    {
        $year = $date->year;
        $month = $date->month;
        $day = $date->day;

        $c = $date->getPreciseTimestamp() / 86400;
        $e = $c - 2451550.1;
        $phase = $e / 29.530588853;

        return $phase - floor($phase);
    }

    /**
     * Find the nearest full moon to a given date
     */
    private function findNearestFullMoon(CarbonImmutable $targetDate): CarbonImmutable
    {
        $date = $targetDate->copy();
        $closestDate = $date;
        $closestDiff = 1;

        // Check 15 days before and after
        for ($i = -15; $i <= 15; $i++) {
            $checkDate = $date->addDays($i);
            $phase = $this->getLunarPhase($checkDate);
            $diff = abs($phase - 0.5);

            if ($diff < $closestDiff) {
                $closestDiff = $diff;
                $closestDate = $checkDate;
            }
        }

        return $closestDate;
    }

    /**
     * Calculate Ashtami (eighth day) date for Hindu festivals
     */
    private function calculateAshtamiDate(CarbonImmutable $baseDate): CarbonImmutable
    {
        $newMoon = $this->findNearestNewMoon($baseDate);
        return $newMoon->addDays(8);
    }

    /**
     * Find the nearest new moon to a given date
     */
    private function findNearestNewMoon(CarbonImmutable $date): CarbonImmutable
    {
        $closestDate = $date;
        $closestDiff = 1;

        for ($i = -15; $i <= 15; $i++) {
            $checkDate = $date->addDays($i);
            $phase = $this->getLunarPhase($checkDate);
            $diff = min($phase, 1 - $phase);

            if ($diff < $closestDiff) {
                $closestDiff = $diff;
                $closestDate = $checkDate;
            }
        }

        return $closestDate;
    }
}