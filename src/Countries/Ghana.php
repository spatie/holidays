<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\Observable;

class Ghana extends Country
{
    use Observable;

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

    /** @return array<string, string|CarbonInterface> */
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

        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                'Christmas Day' => $this->observedChristmasDay($year),
                'Boxing Day' => $this->observedBoxingDay($year),
                default => $this->dayToNextFridayOrMonday($date, $year),
            };

            if ($observedDay) {
                $holidays[$name] = $observedDay;
            }
        }

        return $holidays;
    }

    protected function observed(string $date, int $year): CarbonInterface
    {
        $holiday = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();

        if ($holiday->isWeekend()) {
            return $holiday->next('monday');
        }

        return $holiday;
    }

    /** @return array<string, string|CarbonInterface> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Farmers Day' => CarbonImmutable::parse('first friday of December '.$year),
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),

            // NB: *** There are no fixed dates for the Eid-Ul-Fitr and Eid-Ul-Adha because they are movable feasts.
            // The dates for their observation are provided by the Office of the Chief Imam in the course of the year.
        ];
    }

    protected function dayToNextFridayOrMonday(string|CarbonInterface $date, int $year): ?CarbonInterface
    {
        $christmasDay = new CarbonImmutable($year.'-12-25')->startOfDay();
        $boxingDay = new CarbonImmutable($year.'-12-26')->startOfDay();
        $newYearDay = new CarbonImmutable($year.'-01-01')->startOfDay();

        if (is_string($date)) {
            $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();
        }

        if ($date->isSameDay($christmasDay) || $date->isSameDay($boxingDay) || $date->isSameDay($newYearDay)) {
            return $date;
        }

        if ($date->isWeekend()) {
            return $date->next('monday');
        }

        if ($date->isWeekday() && ! $date->isFriday()) {
            return $date->next('friday');
        }

        return null;
    }
}
