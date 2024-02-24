<?php

namespace Spatie\Holidays\Concerns;

use RuntimeException;
use Carbon\CarbonPeriod;
use Carbon\CarbonImmutable;

trait WeekendHolidays
{
    /**
     * @var array<int>
     */
    protected array $weekendDays = [];

    /**
     * @param int|array $days
     * @return void
     */
    protected function setTheWeekendDays(int|array $days): void
    {
        $this->weekendDays = array_unique([...$this->weekendDays, ...(array) $days]);
    }

    /**
     * @param int $year
     * @return array
     * @throws RuntimeException
     */
    protected function getWeekendHolidays(int $year): array
    {
        $dates = [];

        $date = CarbonImmutable::create($year);

        foreach ($this->weekendDays as $weekendDay) {
            foreach (CarbonPeriod::create($date->startOfMonth(), $date->endOfYear()) as $key => $day) {
                if ($day->dayOfWeek === $weekendDay) {
                    $dates['Weekend - ' . $day->dayName . ' - ' . $key] = $day->format('m-d');
                }
            }
        }

        return $dates;
    }
}
