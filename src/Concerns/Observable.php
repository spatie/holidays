<?php

namespace Spatie\Holidays\Concerns;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

trait Observable
{
    protected function weekendToNextMonday(string|CarbonInterface $date, int $year): ?CarbonInterface
    {
        if (is_string($date)) {
            $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        }

        if ($date->isWeekend()) {
            return $date->next('monday');
        }

        return null;
    }

    protected function dayToNextFridayOrMonday(string|CarbonInterface $date, int $year): ?CarbonInterface
    {
        $christmasDay = (new CarbonImmutable($year.'-12-25'))->startOfDay();
        $boxingDay = (new CarbonImmutable($year.'-12-26'))->startOfDay();
        $newYearDay = (new CarbonImmutable($year.'-01-01'))->startOfDay();

        if (is_string($date)) {
            $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        }

        if ($date->isSameDay($christmasDay) || $date->isSameDay($boxingDay) || $date->isSameDay($newYearDay)) {
            return $date;
        }

        if ($date->isWeekend()) {
            return $date->next('monday');
        }

        if ($date->isWeekday() && !$date->isFriday()) {
            return $date->next('friday');
        }

        return null;
    }

    protected function sundayToNextMonday(string|CarbonInterface $date, int $year): ?CarbonInterface
    {
        if (is_string($date)) {
            $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        }

        if ($date->isSunday()) {
            return $date->next('monday');
        }

        return null;
    }

    protected function observedChristmasDay(int $year): ?CarbonInterface
    {
        $christmasDay = (new CarbonImmutable($year.'-12-25'))->startOfDay();

        return match ($christmasDay->dayName) {
            'Saturday' => $christmasDay->next('monday'),
            'Sunday' => $christmasDay->next('tuesday'),
            default => null,
        };
    }

    protected function observedBoxingDay(int $year): ?CarbonInterface
    {
        $boxingDay = (new CarbonImmutable($year.'-12-26'))->startOfDay();

        return match ($boxingDay->dayName) {
            'Saturday' => $boxingDay->next('monday'),
            'Sunday' => $boxingDay->next('tuesday'),
            default => null,
        };
    }
}
