<?php

namespace Spatie\Holidays\Concerns;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

trait HasObservedHolidays
{
    protected function weekendToNextMonday(CarbonInterface $date): ?CarbonImmutable
    {
        if ($date->isWeekend()) {
            return $date->next('monday')->toImmutable();
        }

        return null;
    }

    protected function sundayToNextMonday(CarbonInterface $date): ?CarbonImmutable
    {
        if ($date->isSunday()) {
            return $date->next('monday')->toImmutable();
        }

        return null;
    }

    protected function observedChristmasDay(CarbonInterface $christmasDay): ?CarbonImmutable
    {
        return match ($christmasDay->dayName) {
            'Saturday' => $christmasDay->next('monday')->toImmutable(),
            'Sunday' => $christmasDay->next('tuesday')->toImmutable(),
            default => null,
        };
    }

    protected function observedBoxingDay(CarbonInterface $boxingDay): ?CarbonImmutable
    {
        return match ($boxingDay->dayName) {
            'Saturday' => $boxingDay->next('monday')->toImmutable(),
            'Sunday' => $boxingDay->next('tuesday')->toImmutable(),
            default => null,
        };
    }
}
