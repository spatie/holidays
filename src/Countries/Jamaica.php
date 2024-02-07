<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class Jamaica extends Country
{
    public function countryCode(): string
    {
        return 'jm';
    }

    protected function allHolidays(int $year): array
    {

        $holidays = array_merge(
            $this->fixedHolidays(),
            $this->variableHolidays($year),
            $this->observedHolidays($year)
        );

        return $holidays;
    }

    /** @return array<string, string> */
    protected function fixedHolidays(): array
    {
        $holidays = [
            'New Year\'s Day' => '01-01',
            'Labour Day' => '05-23',
            'Emancipation Day' => '08-01',
            'Independence Day' => '08-06',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ];

        return $holidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);
        $heroesDay = new CarbonImmutable("third monday of October $year");

        return [
            'Ash Wednesday' => $easter->subDays(46),
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
            'National Heroes Day' => $heroesDay,
        ];
    }

    /** @return array<string, CarbonInterface> */
    protected function observedHolidays(int $year): array
    {

        $observedHolidays = [];

        foreach ($this->fixedHolidays() as $name => $date) {
            $date = CarbonImmutable::parse("$year-$date");

            // If any holiday falls on a Sunday, then it is observed on Monday
            if ($date->dayOfWeek === 0) {
                $observedHolidays["{$name} Observed"] = $date->next(CarbonImmutable::MONDAY);
            }

            // If Labour Day falls on a Saturday, then it is observed on Monday
            if ($name == 'Labour Day' && $date->dayOfWeek === 6) {
                $observedHolidays["{$name} Observed"] = $date->next(CarbonImmutable::MONDAY);
            }

            // If Boxing Day falls on a Monday, then it is observed on Tuesday (Christmas Day is observed on Monday)
            // https://jis.gov.jm/observance-public-holidays-christmas-day-monday-december-26th-boxing-day-tuesday-december-27th/
            if ($name == 'Boxing Day' && $date->dayOfWeek === 1) {
                $observedHolidays["{$name} Observed"] = $date->next(CarbonImmutable::TUESDAY);
            }
        }

        return $observedHolidays;
    }
}
