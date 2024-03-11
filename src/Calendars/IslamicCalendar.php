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
        try {
            $date = self::eidAlFitr[$year];
        } catch (\Exception) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
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

    /** @return CarbonPeriod|array<CarbonPeriod> */
    public function eidAlAdha(int $year, int $totalDays = 4): CarbonPeriod|array
    {
        try {
            $date = self::eidAlAdha[$year];
        } catch (\Exception) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
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
}
