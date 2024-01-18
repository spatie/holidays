<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTime;
use Solaris\MoonPhase;
use Spatie\Holidays\Calendars\ChineseCalendar;
use Spatie\Holidays\Calendars\IndianCalendar;
use Spatie\Holidays\Calendars\IslamicCalendar;

class Singapore extends Country
{
    use ChineseCalendar;
    use IslamicCalendar;
    use IndianCalendar;

    protected string $timezone = "Asia/Singapore";

    public function countryCode(): string
    {
        return 'sg';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->fixedHolidays($year),
            $this->variableHolidays($year)
        );
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function fixedHolidays(int $year): array
    {
        #Fixed holidays in Singapore
        return array_merge(
            $this->replaceHolidayFallsOnSunday("New Year's Day", $year, "01-01"),
            $this->replaceHolidayFallsOnSunday("Labor Day", $year, "05-01"),
            $this->replaceHolidayFallsOnSunday("National Day", $year, "08-09"),
            $this->replaceHolidayFallsOnSunday("Christmas Day", $year, "12-25"),
        );
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {

        $easter = $this->easter($year);

        $this->setChineseCalendarTimezone($this->timezone);
        $this->setIslamicCalendarTimezone($this->timezone);

        return array_merge(
            $this->replaceHolidayFallsOnSunday("Chinese New Year Day 1", $year, $this->chineseToGregorianDate("01-01", $year)->format("m-d"), 2), // In singapore if consecutive holiday falls on sunday and monday, sunday holiday will moved to tuesday
            $this->replaceHolidayFallsOnSunday("Chinese New Year Day 2", $year, $this->chineseToGregorianDate("01-02", $year)->format("m-d")),
            $this->replaceHolidayFallsOnSunday("Hari Raya Pausa", $year, $this->islamicToGregorianDate("01-10", $year)->format("m-d")),
            $this->replaceHolidayFallsOnSunday("Vesak Day", $year, $this->chineseToGregorianDate("04-15", $year)->format("m-d")),
            $this->replaceHolidayFallsOnSunday("Hari Raya Haji", $year, $this->islamicToGregorianDate("10-12", $year)->format("m-d")),
            $this->getDeepavali($year),
            [
                'Good Friday' => $easter->subDays(2),
            ]
        );
    }

    /**
     * @param string $holidayName
     * @param int $year
     * @param string $input
     * @param int $moveDays | For consecutive holidays like Chinese New Year. If holiday falls on sunday and monday, sunday holiday will move to tuesday
     * 
     * @return array<string, string|CarbonImmutable> 
     */
    protected function replaceHolidayFallsOnSunday(string $holidayName, int $year, string $input, int $moveDays = 1): array
    {
        /** @var CarbonImmutable $dateTime */
        $dateTime = CarbonImmutable::createFromFormat("Y-m-d", $year . "-" . $input);

        $replacementDay = [];
        $holiday = [$holidayName => $dateTime->format("m-d")];
        if ($dateTime->isSunday()) {
            $dateTime = $dateTime->addDays($moveDays);
            $replacementDay = ["$holidayName (Replacement)" => $dateTime->format("m-d")];
        }

        return array_merge(
            $holiday,
            $replacementDay
        );
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function getDeepavali(int $year): array
    {
        // Kartik month
        $date = "08-01";

        $deepavaliDateBasedFromIndianCalendar = $this->indianToGregorianDate($date, $year)->format("m-d");

        $regularHoliday = $this->getPhaseNextNewMoon($year . "-" . $deepavaliDateBasedFromIndianCalendar);
        return $this->replaceHolidayFallsOnSunday("Deepavali", $year, $regularHoliday);
    }

    protected function getPhaseNextNewMoon(string $input): string
    {
        $moonPhase = new MoonPhase(new DateTime($input));
        $phaseNextNewMoon = CarbonImmutable::createFromTimestamp((int) $moonPhase->getPhaseNextNewMoon())->subDay()->format("m-d");

        return $phaseNextNewMoon;
    }
}
