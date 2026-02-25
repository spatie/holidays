<?php

namespace Spatie\Holidays\Concerns;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

trait Observable
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

    protected function observedChristmasDay(int $year): ?CarbonInterface
    {
        $christmasDay = new CarbonImmutable($year.'-12-25')->startOfDay();

        return match ($christmasDay->dayName) {
            'Saturday' => $christmasDay->next('monday'),
            'Sunday' => $christmasDay->next('tuesday'),
            default => null,
        };
    }

    protected function observedBoxingDay(int $year): ?CarbonInterface
    {
        $boxingDay = new CarbonImmutable($year.'-12-26')->startOfDay();

        return match ($boxingDay->dayName) {
            'Saturday' => $boxingDay->next('monday'),
            'Sunday' => $boxingDay->next('tuesday'),
            default => null,
        };
    }
}
