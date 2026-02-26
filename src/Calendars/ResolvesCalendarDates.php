<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Carbon\Exceptions\InvalidFormatException;
use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Exceptions\InvalidYear;

/** @mixin Country */
trait ResolvesCalendarDates
{
    /** @param array<int, string> $collection */
    protected function getSingleDayHoliday(array $collection, int $year): CarbonImmutable
    {
        $date = $collection[$year] ?? null;

        if ($date === null) {
            $this->throwUnsupportedYear($collection);
        }

        $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")?->startOfDay();

        if ($date === null) {
            throw new InvalidFormatException('Invalid date for holiday');
        }

        return $date;
    }

    /**
     * @param  array<int, string|array<string>>  $collection
     * @return array<CarbonPeriod>
     */
    protected function getMultiDayHoliday(array $collection, int $year, int $totalDays): array
    {
        $date = $collection[$year] ?? null;

        if ($date === null) {
            return [];
        }

        $overlap = $this->getOverlapping($collection, $year, $totalDays);

        if ($overlap) {
            $period = $this->createPeriod($overlap, $year - 1, $totalDays);

            $date = [$period, $date];
        }

        if (! is_array($date)) {
            return [$this->createPeriod($date, $year, $totalDays)];
        }

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
        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")?->startOfDay();

        if ($start === null) {
            throw new \RuntimeException("Invalid date format: {$year}-{$date}");
        }

        $end = $start->addDays($totalDays - 1)->startOfDay();

        return CarbonPeriod::create($start, '1 day', $end);
    }

    /** @param array<int, string|array<string>> $collection */
    protected function getOverlapping(array $collection, int $year, int $totalDays): ?string
    {
        /** @var non-empty-array<int, string|array<string>> $collection */
        $minYear = min(array_keys($collection));

        if ($year <= $minYear) {
            return null;
        }

        $date = $collection[$year - 1] ?? null;

        if ($date === null) {
            $this->throwUnsupportedYear($collection);
        }

        if (is_array($date)) {
            $date = end($date);
        }

        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")?->startOfDay();
        $end = $start?->addDays($totalDays - 1)->startOfDay();

        return ($end?->year !== $year) ? (string) $date : null;
    }

    /** @param array<int, mixed> $collection */
    private function throwUnsupportedYear(array $collection): never
    {
        $keys = array_keys($collection);
        $min = $keys ? min($keys) : 0;
        $max = $keys ? max($keys) : 0;

        throw InvalidYear::range($this->countryCode(), $min, $max);
    }
}
