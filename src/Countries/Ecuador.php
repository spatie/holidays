<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\HasObservedHolidays;

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
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
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

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);
        $ashWednesday = $easter->subDays(46);

        return [
            'Holy Friday' => $easter->subDays(2),
            'Carnival Monday' => $ashWednesday->subDays(2),
            'Carnival Tuesday' => $ashWednesday->subDay(),
            'Labor Day' => $this->nearestDay($year, 5, 1),
            'Battle of Pichincha' => $this->nearestDay($year, 5, 24),
            'Independence Day' => $this->nearestDay($year, 8, 10),
            'Independence Of Guayaquil' => $this->nearestDay($year, 10, 9),
            "All Souls' Day" => $this->nearestDay($year, 11, 2),
            'Independence Of Cuenca' => $this->nearestDay($year, 11, 3),
            'Christmas' => $this->getChristmasHoliday($year),
        ];
    }
}
