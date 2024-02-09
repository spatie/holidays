<?php

namespace Spatie\Holidays\Concerns;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

trait Observable
{
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
        $christmasDay = (new CarbonImmutable($year.'-12-25'))->startOfDay();
        $boxingDay = $christmasDay->addDay();

        return match ($christmasDay->dayName) {
            'Friday' => $boxingDay->next('monday'),
            'Saturday' => $boxingDay->next('tuesday'),
            default => null,
        };
    }

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

    protected function sundayToNextMonday(CarbonInterface $date): ?CarbonInterface
    {
        if ($date->isSunday()) {
            return $date->next('monday');
        }

        return null;
    }
}
