<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Carbon\Exceptions\InvalidFormatException;
use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Exceptions\InvalidYear;

/** @mixin Country */
trait IslamicCalendar
{
    /** @return array<CarbonPeriod> */
    public function eidAlFitr(int $year, int $totalDays = 3): array
    {
        return $this->getMultiDayHoliday(self::eidAlFitr, $year, $totalDays);
    }

    /** @return array<CarbonPeriod> */
    public function eidAlAdha(int $year, int $totalDays = 4): array
    {
        return $this->getMultiDayHoliday(self::eidAlAdha, $year, $totalDays);
    }

    /** @return array<CarbonPeriod> */
    protected function ashura(int $year, int $totalDays = 2): array
    {
        return $this->getMultiDayHoliday(self::ashura, $year, $totalDays);
    }

    protected function arafat(int $year): CarbonImmutable
    {
        return $this->getSingleDayHoliday(self::arafat, $year);
    }

    protected function islamicNewYear(int $year): CarbonImmutable
    {
        return $this->getSingleDayHoliday(self::islamicNewYear, $year);
    }

    protected function prophetMuhammadBirthday(int $year): CarbonImmutable
    {
        return $this->getSingleDayHoliday(self::prophetMuhammadBirthday, $year);
    }

    /** @param array<string> $collection */
    protected function getSingleDayHoliday(array $collection, int $year): CarbonImmutable
    {
        $date = $collection[$year] ?? null;

        if ($date === null) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")?->startOfDay();

        if ($date === null) {
            throw new InvalidFormatException('Invalid date for holiday');
        }

        return $date;
    }

    /**
     * @param  array<string|array<string>>  $collection
     * @return array<CarbonPeriod>
     */
    protected function getMultiDayHoliday(array $collection, int $year, int $totalDays): array
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
            return [$this->createPeriod($date, $year, $totalDays)];
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
        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")?->startOfDay();
        $end = $start->addDays($totalDays - 1)->startOfDay();

        return CarbonPeriod::create($start, '1 day', $end);
    }

    /** @param array<string|array<string>> $collection */
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

        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")?->startOfDay();
        $end = $start->addDays($totalDays - 1)->startOfDay();

        if ($end->year !== $year) {
            return (string) $date;
        }

        return null;
    }
}
