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
            'New Year\'s Day' => '01-01',
            'Constitution Day' => '01-07',
            'Independence Day' => '03-06',
            'May Day' => '05-01',
            'Founder\'s Day' => '08-04',
            'Kwame Nkrumah Memorial Day' => '09-21',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ];

        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                'Christmas Day' => $this->observedChristmasDay($year),
                'Boxing Day' => $this->observedBoxingDay($year),
                default => $this->weekendToNextMonday($date, $year),
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
            'Farmers Day' => 'first friday of December',
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),

            // NB: *** There are no fixed dates for the Eid-Ul-Fitr and Eid-Ul-Adha because they are movable feasts.
            // The dates for their observation are provided by the Office of the Chief Imam in the course of the year.
        ];
    }
}
