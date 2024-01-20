<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use GeniusTS\HijriDate\Hijri;

class Maldives extends Country
{
    protected $adjustmentDays = 1; // Adjustments based on moon sighting

    public function countryCode(): string
    {
        return 'mv';
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        // Fixed-date holidays
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Labour Day' => '05-01',
            'Independence Day' => '07-26',
            'On the occasion of the Independence Day' => '07-27',
            'Victory Day' => '11-03',
            'Republic Day' => '11-11',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // Ramadan
        $firstDayOfRamadan = $this->getHijriDateAsGregorian(1, 9, $year, $this->adjustmentDays); // Ramadan 1
        $last10DaysOfRamadan = $this->getLastTenDaysOfRamadan($year); // Last 10 days

        // Eid al-Fitr and the two days following it - Shawwal 1, 2, 3
        $eidAlFitr = $this->getHijriDateAsGregorian(1, 10, $year, $this->adjustmentDays);
        list($secondDayOfEidAlFitr, $thirdDayOfEidAlFitr) = $this->getDaysFollowingEid($eidAlFitr);

        // Hajj Day - Dhu al-Hijjah 9
        $hajjDay = $this->getHijriDateAsGregorian(9, 12, $year, $this->adjustmentDays);

        // Eid al-Adha and the two days following it - Dhu al-Hijjah 10, 11, 12
        $eidAlAdha = $this->getHijriDateAsGregorian(10, 12, $year, $this->adjustmentDays);
        list($secondDayOfEidAlAdha, $thirdDayOfEidAlAdha) = $this->getDaysFollowingEid($eidAlAdha);

        // Islamic New Year - Muharram 1
        $islamicNewYear = $this->getHijriDateAsGregorian(1, 1, $year + 1);

        // National Day - Rabi' al-Awwal 1
        $nationalDay = $this->getHijriDateAsGregorian(1, 3, $year + 1);

        // Prophet Muhammad's Birthday - Rabi' al-Awwal 12 // +1 because it's in next hijri year)
        $prophetMuhammadsBirthday = $this->getHijriDateAsGregorian(12, 3, $year + 1);

        // The Day Maldives Embraced Islam - Rabi' al-Akhir 2 // +1 because it's in next hijri year
        $theDayMaldivesEmbracedIslam = $this->getHijriDateAsGregorian(2, 4, $year + 1);

        $variableHolidays = [
            'First day of Ramadan' => $firstDayOfRamadan,
            'Eid al-Fitr' => $eidAlFitr,
            'On the occasion of Eid al-Fitr - 2nd day' => $secondDayOfEidAlFitr,
            'On the occasion of Eid al-Fitr - 3rd day' => $thirdDayOfEidAlFitr,
            'Hajj Day' => $hajjDay,
            'Eid al-Adha' => $eidAlAdha,
            'On the occasion of Eid al-Adha - 2nd day' => $secondDayOfEidAlAdha,
            'On the occasion of Eid al-Adha - 3rd day' => $thirdDayOfEidAlAdha,
            'Islamic New Year' => $islamicNewYear,
            'National Day' => $nationalDay,
            'Prophet Muhammad (SAW)\'s Birthday' => $prophetMuhammadsBirthday,
            'The Day Maldives Embraced Islam' => $theDayMaldivesEmbracedIslam,
        ];

        return array_merge($variableHolidays, $last10DaysOfRamadan);
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

        // Get the 1st of Shawwal (Eid al-Fitr)
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
     * @return array
     */
    protected function getDaysFollowingEid(CarbonImmutable $eidDay): array
    {
        $secondDay = $eidDay->addDay();
        $thirdDay = $eidDay->addDays(2);
        return [$secondDay, $thirdDay];
    }
}
