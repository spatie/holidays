<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\HasObservedHolidays;
use Spatie\Holidays\Holiday;

class Ecuador extends Country
{
    use HasObservedHolidays;

    public function countryCode(): string
    {
        return 'ec';
    }

    protected function defaultLocale(): string
    {
        return 'es';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
        ], $this->variableHolidays($year));
    }

    public function nearestDay(int $year, int $month, int $day): CarbonImmutable
    {
        $date = CarbonImmutable::createFromDate($year, $month, $day);

        if ($date->is('Tuesday') || $date->is('Saturday')) {
            return $date->subDay();
        }

        if ($date->is('Sunday')) {
            return $date->addDay();
        }

        if ($date->is('Wednesday') || $date->is('Thursday')) {
            return $date->next(CarbonInterface::FRIDAY)->toImmutable();
        }

        return $date;
    }

    public function getChristmasHoliday(int $year): CarbonImmutable
    {
        if ($year === 2022) {
            $observedChristmasDay = $this->sundayToNextMonday(CarbonImmutable::createFromDate($year, 12, 25));

            if ($observedChristmasDay !== null) {
                return $observedChristmasDay;
            }
        }

        return CarbonImmutable::createFromDate($year, 12, 25);
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);
        $ashWednesday = $easter->subDays(46);

        return [
            Holiday::national('Holy Friday', $easter->subDays(2)),
            Holiday::national('Carnival Monday', $ashWednesday->subDays(2)),
            Holiday::national('Carnival Tuesday', $ashWednesday->subDay()),
            Holiday::national('Labor Day', $this->nearestDay($year, 5, 1)),
            Holiday::national('Battle of Pichincha', $this->nearestDay($year, 5, 24)),
            Holiday::national('Independence Day', $this->nearestDay($year, 8, 10)),
            Holiday::national('Independence Of Guayaquil', $this->nearestDay($year, 10, 9)),
            Holiday::national("All Souls' Day", $this->nearestDay($year, 11, 2)),
            Holiday::national('Independence Of Cuenca', $this->nearestDay($year, 11, 3)),
            Holiday::national('Christmas', $this->getChristmasHoliday($year)),
        ];
    }
}
