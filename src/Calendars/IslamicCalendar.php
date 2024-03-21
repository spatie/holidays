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

    /** @return CarbonPeriod|array<CarbonPeriod> */
    protected function ashura(int $year, int $totalDays = 2): CarbonPeriod|array
    {
        return $this->getHoliday(self::ashura, $year, $totalDays);
    }

    /**
     * @param  array<int, string|array<string>>  $collection
     * @return CarbonPeriod|array<CarbonPeriod>
     */
    protected function getHoliday(array $collection, int $year, int $totalDays): CarbonPeriod|array
    {
        $date = $collection[$year] ?? null;

        if ($date === null) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        $overlap = $this->getOverlapping($collection, $year, $totalDays);

        if ($overlap) {
            $period = $this->createPeriod($overlap, $year - 1, $totalDays);

            $date = [$period, $date];
        }

        if (! is_array($date)) {
            return $this->createPeriod($date, $year, $totalDays);
        }

        // Twice a year
        $periods = [];
        $dates = $date;

        /** @var CarbonPeriod|string $date */
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
        $end = $start->addDays($totalDays - 1)->startOfDay();

        return CarbonPeriod::create($start, '1 day', $end);
    }

    /** @param array<int, string|array<string>> $collection */
    protected function getOverlapping(array $collection, int $year, int $totalDays): ?string
    {
        if ($year === 1970) {
            return null;
        }

        $date = $collection[$year - 1] ?? null;

        if ($date === null) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        if (is_array($date)) {
            $date = end($date);
        }

        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        $end = $start->addDays($totalDays - 1)->startOfDay();

        if ($end->year !== $year) {
            return (string) $date;
        }

        return null;
    }
}
