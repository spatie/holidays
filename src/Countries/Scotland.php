<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class Scotland extends Wales
{
    public function countryCode(): string
    {
        return 'gb-sct';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->observedHolidays($year),
            $this->earlyMayBankHoliday($year),
            $this->variableHolidays($year),
            $this->oneOffHolidays($year),
        );
    }

    /** @return array<string, string|CarbonInterface> */
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            'New Year\'s Day' => '01-01',
            '2nd January' => '01-02',
            'St Andrew\'s Day' => '11-30',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ];

        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                '2nd January' => $this->secondOfJanuary($year),
                'Christmas Day' => $this->observedChristmasDay($year),
                'Boxing Day' => $this->observedBoxingDay($year),
                default => $this->weekendToNextMonday($date, $year),
            };

            if ($observedDay) {
                $holidays[$name.' (substitute day)'] = $observedDay;
                unset($holidays[$name]);
            }
        }

        return $holidays;
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Good Friday' => $easter->subDays(2),
            'Spring bank holiday' => 'last monday of may',
            'Summer bank holiday' => 'first monday of august',
        ];
    }

    protected function secondOfJanuary(int $year): ?CarbonInterface
    {
        $newYearsDay = (new CarbonImmutable($year.'-01-01'))->startOfDay();
        $secondOfJanuary = $newYearsDay->addDay();

        return match ($newYearsDay->dayName) {
            'Friday' => $secondOfJanuary->next('monday'),
            'Saturday', 'Sunday' => $secondOfJanuary->next('tuesday'),
            default => null,
        };
    }
}
