<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use GeniusTS\HijriDate\Hijri;

class Algeria extends Country
{
    protected int $adjustmentDays = 1;

    public function countryCode(): string
    {
        return 'dz';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge($this->fixedHolidays($year), $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function fixedHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => CarbonImmutable::createFromDate($year, 1, 1),
            'Amazigh New Year' => CarbonImmutable::createFromDate($year, 1, 12),
            'Labour day' => CarbonImmutable::createFromDate($year, 5, 1),
            'Independence day' => CarbonImmutable::createFromDate($year, 7, 5),
            'Revolution Day' => CarbonImmutable::createFromDate($year, 11, 1),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [
            'Islamic new year' => $this->getHijriDateAsGregorian(1, 1, $year + 1),
            'Ashura' =>  $this->getHijriDateAsGregorian(10, 1, $year + 1),
            'Mawlid' =>  $this->getHijriDateAsGregorian(12, 3, $year + 1),
            'Eid al-Fitr' =>  $this->getHijriDateAsGregorian(1, 10, $year, $this->adjustmentDays),
            'Eid al-Fitr - 2nd day' =>  $this->getHijriDateAsGregorian(2, 10, $year, $this->adjustmentDays),
            'Eid al-Adha' =>  $this->getHijriDateAsGregorian(10, 12, $year, $this->adjustmentDays),
            'Eid al-Adha - 2nd day' =>  $this->getHijriDateAsGregorian(11, 12, $year, $this->adjustmentDays),
            'Eid al-Adha - 3rd day' =>  $this->getHijriDateAsGregorian(12, 12, $year, $this->adjustmentDays),
        ];
    }

    /**
     * @param int $year
     * @return int
     */
    protected function convertToHijriYear(int $year): int
    {
        $gregorianNewYear = CarbonImmutable::create($year, 1, 1);
        $hijriNewYear = Hijri::convertToHijri($gregorianNewYear);
        $hijriYear = $hijriNewYear->year;

        return $hijriYear;
    }

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
     * Calculates the last 10 days of Ramadan for a given year.
     *
     * @param int $year
     * @return array<string, CarbonImmutable>
     */
    protected function getLastTenDaysOfRamadan(int $year): array
    {
        $last10DaysOfRamadan = [];

        $eidAlFitr = $this->getHijriDateAsGregorian(1, 10, $year, $this->adjustmentDays); // Shawwal 1

        for ($i = 9; $i >= 0; $i--) {
            $day = $eidAlFitr->subDays($i + 1); // Counting back from the day before Eid al-Fitr
            $last10DaysOfRamadan["Last 10 Days of Ramadan - Day " . (10 - $i)] = $day;
        }
        return $last10DaysOfRamadan;
    }

    /**
     * Calculates the length of Ramadan for a given year.
     *
     * @param int $year
     * @return int
     */
    protected function getLengthOfRamadan(int $year): int
    {
        $firstDayOfRamadan = $this->getHijriDateAsGregorian(1, 9, $year); // Ramadan 1
        $lastDayOfRamadan = $this->getHijriDateAsGregorian(1, 10, $year); // Shawwal 1
        $lengthOfRamadan = $firstDayOfRamadan->diffInDays($lastDayOfRamadan);
        return $lengthOfRamadan;
    }

    /**
     * Get the two days following an Eid day.
     *
     * @param CarbonImmutable $eidDay
     * @return array<int, CarbonImmutable>
     */
    protected function getDaysFollowingEid(CarbonImmutable $eidDay): array
    {
        $secondDay = $eidDay->addDay();
        $thirdDay = $eidDay->addDays(2);
        return [$secondDay, $thirdDay];
    }
}
