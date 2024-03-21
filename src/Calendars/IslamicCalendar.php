<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
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

        $overlap = $this->getOverlapping($collection, $year, $totalDays);

        if ($overlap) {
            $period = $this->createPeriod($overlap, $year -1, $totalDays);

            $date = [$period, $date];
        }

        if (! is_array($date)) {
            return $this->createPeriod($date, $year, $totalDays);
        }

        // Twice a year
        $periods = [];
        $dates = $date;

        foreach ($dates as $date) {
            if ($date instanceof CarbonPeriod) {
                $periods[] = $date;
                continue;
            }

            $periods[] = $this->createPeriod($date, $year, $totalDays);
        }

        return $periods;
    }

    protected function createPeriod(string $date, int $year, int $totalDays): CarbonPeriod
    {
        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        $end = $start->addDays($totalDays -1)->startOfDay();

        return CarbonPeriod::create($start, '1 day', $end);
    }

    protected function getOverlapping(array $collection, int $year, $totalDays): ?string
    {
        if ($year === 1970) {
            return null;
        }

        try {
            $date = $collection[$year - 1];
        } catch (\Exception) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        if (is_array($date)) {
            $date = end($date);
        }

        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        $end = $start->addDays($totalDays - 1)->startOfDay();

        if ($end->year !== $year) {
            return $date;
        }

        return null;
    }
}
