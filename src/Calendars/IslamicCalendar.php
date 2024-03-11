<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use RuntimeException;
use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Exceptions\InvalidYear;

/** @mixin Country */
trait IslamicCalendar
{
    /** @return CarbonPeriod|array<CarbonPeriod> */
    public function eidAlFitr(int $year, int $totalDays = 3): CarbonPeriod|array
    {
        return $this->getHoliday(self::eidAlFitr, $year, $totalDays);
    }

    /** @return CarbonPeriod|array<CarbonPeriod> */
    public function eidAlAdha(int $year, int $totalDays = 4): CarbonPeriod|array
    {
        return $this->getHoliday(self::eidAlAdha, $year, $totalDays);
    }

    protected function getHoliday(array $collection, int $year, int $totalDays): CarbonPeriod|array
    {
        try {
            $date = $collection[$year];
        } catch (\Exception) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        $overlap = $this->getOverlapping(self::eidAlFitr, $year, $totalDays);

        if ($overlap) {
            $date = [$date, $overlap];
        }

        if (! is_array($date)) {
            $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
            $end = $start->addDays($totalDays - 1)->startOfDay();

            return CarbonPeriod::create($start, '1 day', $end);
        }

        // Twice a year
        $periods = [];
        $dates = $date;

        foreach ($dates as $date) {
            $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
            $end = $start->addDays($totalDays-1)->startOfDay();
            $periods[] = CarbonPeriod::create($start, '1 day', $end);
        }

        return $periods;
    }

    protected function getOverlapping(array $collection, int $year, $totalDays): ?string
    {
        try {
            $date = $collection[$year-1];
        } catch (\Exception) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        if (is_array($date)) {
            $date = end($date);
        }

        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        $end = $start->addDays($totalDays-1)->startOfDay();

        if ($end->year !== $year) {
            return $date;
        }

        return null;
    }
}
