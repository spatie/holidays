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
    public function eidAlFitr(int $year, int $totalDays = 3): CarbonPeriod
    {
        try {
            $date = self::eidAlFitr[$year];
        } catch (RuntimeException) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        $end = $start->addDays($totalDays-1)->startOfDay();

        return CarbonPeriod::create($start, '1 day', $end);
    }

    protected function convertPeriods(
        array $holidays,
        string $suffix = 'Day',
        string $prefix = ''
    ): array {
        $result = [];

        foreach ($holidays as $name => $holiday) {
            if ($holiday instanceof CarbonPeriod) {
                foreach ($holiday as $index => $day) {
                    $holidayName = "{$prefix}{$name} {$suffix} " . $index+1;

                    $result[$holidayName] = $day->toImmutable();
                }
            } else {
                $result[$name] = $holiday;
            }
        }

        return $result;
    }
}
