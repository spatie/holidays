<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use GeniusTS\HijriDate\Hijri;

class Egypt extends Country
{
    public function countryCode(): string
    {
        return 'eg';
    }

    /**
     * @param int $year
     * @return array<string, bool|CarbonImmutable>
     */
    protected function allHolidays(int $year): array
    {
        $fixedHolidays = $this->getFixedHolidays($year);
        $variableHolidays = $this->variableHolidays($year);

        return array_merge($fixedHolidays, $variableHolidays);
    }

    /**
     * @param int $year
     * @return array<string, bool|CarbonImmutable>
     */
    protected function variableHolidays(int $year): array
    {
        $orthodoxEaster = $this->orthodoxEaster($year);

        $otherHolidays = [
            'Coptic Good Friday' => $orthodoxEaster->subDays(2)->toImmutable(),
            'Coptic Holy Saturday' => $orthodoxEaster->subDays()->toImmutable(),
            'Coptic Easter Sunday' => $orthodoxEaster->toImmutable(),
            'Flooding of the Nile' => CarbonImmutable::create($year, 8, 15),
            'March Equinox' => CarbonImmutable::create($year, 3, 20),
            'June Solstice' => CarbonImmutable::create($year, 6, 21),
            'September Equinox' => CarbonImmutable::create($year, 9, 22),
            'Nayrouz' => CarbonImmutable::create($year, 9, 11),
            'December Solstice' => CarbonImmutable::create($year, 12, 21),
        ];

        $hijriHolidays = [
            'Islamic New Year' => '01-01',
            'Ashura' => '01-10',
            'Birthday of the Prophet Muhammad' => '03-12',
            'Eid al-Fitr' => '10-01',
            'Eid al-Fitr Day 2' => '10-02',
            'Eid al-Fitr Day 3' => '10-03',
            'Arafat Day' => '12-09',
            'Eid al-Adha' => '12-10',
            'Eid al-Adha Day 2' => '12-11',
            'Eid al-Adha Day 3' => '12-12',
            'Eid al-Adha Day 4' => '12-13',
        ];

        return array_merge($otherHolidays, $this->convertHijriToGregorianHolidays($hijriHolidays, $year));
    }

    /**
     * @param int $year
     * @return array<string, bool|CarbonImmutable>
     */
    private function getFixedHolidays(int $year): array
    {
        $holidays = [
            'Coptic Christmas Day' => CarbonImmutable::create($year, 1, 7),
            'Revolution Day 2011' => CarbonImmutable::create($year, 1, 25),
            'Sinai Liberation Day' => CarbonImmutable::create($year, 4, 25),
            'Labour Day' => CarbonImmutable::create($year, 5, 1),
            'June 30 Revolution' => CarbonImmutable::create($year, 6, 30),
            'Revolution Day' => CarbonImmutable::create($year, 7, 23),
            'Armed Forces Day' => CarbonImmutable::create($year, 10, 6),
            'Spring Festival' => $this->orthodoxEaster($year)->addDay()->toImmutable()
        ];

        foreach ($holidays as $name => $date) {
            $holidays = array_merge($holidays, $this->adjustForWeekend($name, $date));
        }

        return $holidays;
    }

    /**
     * @param array<string, string> $hijriHolidays
     * @param int $year
     * @return array<string, CarbonImmutable>
     */
    private function convertHijriToGregorianHolidays(array $hijriHolidays, int $year): array
    {
        /**
         * ---------------------------------------------------------------
         * Code Adaptation
         * ---------------------------------------------------------------
         * This strategy was adapted from PR #56.
         * Original contribution by: YazidKHALDI
         * See: https://github.com/spatie/holidays/pull/56/
         * ---------------------------------------------------------------
         */

        Hijri::setDefaultAdjustment(-1);

        $currentHijriYear = (int)Hijri::convertToHijri($year . "-01-01")->format('Y');
        $gregorianHolidays = [];

        foreach ($hijriHolidays as $holidayName => $hijriDate) {
            $gregorianDate = $this->getGregorianDateForHijriHoliday($hijriDate, $currentHijriYear, $year);
            if (!is_null($gregorianDate)) {
                $gregorianHolidays[$holidayName] = $gregorianDate;
            }
        }

        return $gregorianHolidays;
    }

    /**
     * @param string $hijriDate
     * @param int $hijriYear
     * @param int $gregorianYear
     * @return CarbonImmutable|null
     */
    private function getGregorianDateForHijriHoliday(string $hijriDate, int $hijriYear, int $gregorianYear): ?CarbonImmutable
    {
        list($month, $day) = explode('-', $hijriDate);
        $currentYearDate = Hijri::convertToGregorian((int)$day, (int)$month, $hijriYear);

        if ($currentYearDate->format('Y') == $gregorianYear) {
            return $currentYearDate->toImmutable();
        }

        $nextYearDate = Hijri::convertToGregorian((int)$day, (int)$month, $hijriYear + 1);
        if ($nextYearDate->format('Y') == $gregorianYear) {
            return $nextYearDate->toImmutable();
        }

        return null;
    }

    /**
     * @param string $name
     * @param CarbonImmutable|false $date
     * @return array<string, CarbonImmutable>
     */
    private function adjustForWeekend(string $name, CarbonImmutable|false $date): array
    {
        $adjustedHolidays = [];

        // Explicitly define this logic to avoid timezone confusion on the CarbonInterface::next() method
        if ($date) {
            if ($date->isFriday() || $date->isSaturday()) {
                // If the holiday falls on a weekend (Friday or Saturday), it is observed on the following Sunday
                $adjustedHolidays['Day off for ' . $name] = $date->next(CarbonInterface::SUNDAY);
            } elseif ($date->isSunday() || $date->isThursday()) {
                // If the holiday falls on a Sunday, it is observed on the same day
                $adjustedHolidays[$name] = $date;
            } else {
                // If the holiday falls on a weekday (Monday, Tuesday, Wednesday), it is observed on the following Thursday
                $adjustedHolidays['Day off for ' . $name] = $date->next(CarbonInterface::THURSDAY);
            }
        }

        return $adjustedHolidays;
    }
}
