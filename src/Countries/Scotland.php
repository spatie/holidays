<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class Scotland extends Wales
{
    #[\Override]
    public function countryCode(): string
    {
        return 'gb-sct';
    }

    #[\Override]
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
    #[\Override]
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            '2nd January' => CarbonImmutable::createFromDate($year, 1, 2),
            "St Andrew's Day" => CarbonImmutable::createFromDate($year, 11, 30),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
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

    /** @return array<string, CarbonImmutable> */
    #[\Override]
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Good Friday' => $easter->subDays(2),
            'Spring bank holiday' => CarbonImmutable::parse('last monday of may '.$year),
            'Summer bank holiday' => CarbonImmutable::parse('first monday of august '.$year),
        ];
    }

    protected function secondOfJanuary(int $year): ?CarbonInterface
    {
        $newYearsDay = new CarbonImmutable($year.'-01-01')->startOfDay();
        $secondOfJanuary = $newYearsDay->addDay();

        return match ($newYearsDay->dayName) {
            'Friday' => $secondOfJanuary->next('monday'),
            'Saturday', 'Sunday' => $secondOfJanuary->next('tuesday'),
            default => null,
        };
    }
}
