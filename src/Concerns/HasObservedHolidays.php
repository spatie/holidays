<?php

namespace Spatie\Holidays\Concerns;

use Carbon\CarbonInterface;

trait HasObservedHolidays
{
    protected function weekendToNextMonday(CarbonInterface $date): ?CarbonInterface
    {
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

    protected function observedChristmasDay(CarbonInterface $christmasDay): ?CarbonInterface
    {
        return match ($christmasDay->dayName) {
            'Saturday' => $christmasDay->next('monday'),
            'Sunday' => $christmasDay->next('tuesday'),
            default => null,
        };
    }

    protected function observedBoxingDay(CarbonInterface $boxingDay): ?CarbonInterface
    {
        return match ($boxingDay->dayName) {
            'Saturday' => $boxingDay->next('monday'),
            'Sunday' => $boxingDay->next('tuesday'),
            default => null,
        };
    }
}
