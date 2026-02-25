<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonPeriod;
use Spatie\Holidays\Countries\Country;

/** @mixin Country */
trait IndianCalendar
{
    use ResolvesCalendarDates;

    /** @return array<CarbonPeriod> */
    protected function ashura(int $year, int $totalDays = 1): array
    {
        return $this->getMultiDayHoliday(self::ashura, $year, $totalDays);
    }

    /** @return array<CarbonPeriod> */
    protected function miladHolidays(int $year, int $totalDays = 1): array
    {
        return $this->getMultiDayHoliday(self::miladHolidays, $year, $totalDays);
    }

    /** @return array<CarbonPeriod> */
    protected function bakridHolidays(int $year, int $totalDays = 1): array
    {
        return $this->getMultiDayHoliday(self::bakridHolidays, $year, $totalDays);
    }

    /** @return array<CarbonPeriod> */
    protected function ramzanIdHolidays(int $year, int $totalDays = 1): array
    {
        return $this->getMultiDayHoliday(self::ramzanIdHolidays, $year, $totalDays);
    }
}
