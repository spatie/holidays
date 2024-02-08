<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class Ghana extends Country
{
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

    /** @return array<string, CarbonInterface> */
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            'New Year\'s Day' => '01-01',
            'Constitution Day' => '01-07',
            'Independence Day' => '03-06',
            'May Day' => '05-01',
            'Founder\'s Day' => '08-04',
            'Kwame Nkrumah Memorial Day' => '09-21',
        ];

        $holidays = array_map(function ($holiday) use ($year) {
            return $this->observed($holiday, $year);
        }, $holidays);

        return array_merge($holidays, [
            'Christmas Day' => $this->observedChristmasDay($year),
            'Boxing Day' => $this->observedBoxingDay($year),
        ]);
    }

    protected function observed(string $date, int $year): CarbonInterface
    {
        $holiday = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();

        if ($holiday->isWeekend()) {
            return $holiday->next('monday');
        }

        return $holiday;
    }

    protected function christmas(int $year): CarbonInterface
    {
        return (new CarbonImmutable($year.'-12-25'))->startOfDay();
    }

    protected function observedChristmasDay(int $year): CarbonInterface
    {
        $christmasDay = $this->christmas($year);

        return match ($christmasDay->dayName) {
            'Saturday' => $christmasDay->next('monday'),
            'Sunday' => $christmasDay->next('tuesday'),
            default => $christmasDay,
        };
    }

    protected function observedBoxingDay(int $year): CarbonInterface
    {
        $christmasDay = $this->christmas($year);
        $boxingDay = new CarbonImmutable($year.'-12-26');

        return match ($christmasDay->dayName) {
            'Friday' => $boxingDay->next('monday'),
            'Saturday' => $boxingDay->next('tuesday'),
            default => $boxingDay,
        };
    }

    /** @return array<string, string|CarbonInterface> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Farmers Day' => 'first friday of December',
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),

            // NB: *** There are no fixed dates for the Eid-Ul-Fitr and Eid-Ul-Adha because they are movable feasts.
            // The dates for their observation are provided by the Office of the Chief Imam in the course of the year.
        ];
    }
}
