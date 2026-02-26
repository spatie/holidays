<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\HasObservedHolidays;
use Spatie\Holidays\Holiday;

class Ghana extends Country
{
    use HasObservedHolidays;

    public function countryCode(): string
    {
        return 'gh';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->observedHolidays($year),
            $this->variableHolidays($year),
        );
    }

    /** @return array<Holiday> */
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'Constitution Day' => CarbonImmutable::createFromDate($year, 1, 7),
            'Independence Day' => CarbonImmutable::createFromDate($year, 3, 6),
            'May Day' => CarbonImmutable::createFromDate($year, 5, 1),
            "Founder's Day" => CarbonImmutable::createFromDate($year, 9, 21),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
        ];

        $result = [];
        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                'Christmas Day' => $this->observedChristmasDay($date),
                'Boxing Day' => $this->observedBoxingDay($date),
                default => $this->dayToNextFridayOrMonday($date, $year),
            };

            if ($observedDay) {
                $result[] = Holiday::national($name, $observedDay);
            } else {
                $result[] = Holiday::national($name, $date);
            }
        }

        return $result;
    }

    protected function observed(string $date, int $year): CarbonImmutable
    {
        $holiday = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();

        if ($holiday->isWeekend()) {
            return $holiday->next('monday')->toImmutable();
        }

        return $holiday;
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Farmers Day', CarbonImmutable::parse("first friday of December {$year}")),
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('Easter Monday', $easter->addDay()),
        ];
    }

    protected function dayToNextFridayOrMonday(string|CarbonInterface $date, int $year): ?CarbonImmutable
    {
        $christmasDay = new CarbonImmutable("{$year}-12-25")->startOfDay();
        $boxingDay = new CarbonImmutable("{$year}-12-26")->startOfDay();
        $newYearDay = new CarbonImmutable("{$year}-01-01")->startOfDay();

        if (is_string($date)) {
            $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        }

        if ($date->isSameDay($christmasDay) || $date->isSameDay($boxingDay) || $date->isSameDay($newYearDay)) {
            return $date->toImmutable();
        }

        if ($date->isWeekend()) {
            return $date->next('monday')->toImmutable();
        }

        if ($date->isWeekday() && ! $date->isFriday()) {
            return $date->next('friday')->toImmutable();
        }

        return null;
    }
}
