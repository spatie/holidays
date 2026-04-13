<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\HasObservedHolidays;
use Spatie\Holidays\Holiday;

class SouthAfrica extends Country
{
    use HasObservedHolidays;

    public function countryCode(): string
    {
        return 'za';
    }

    protected function allHolidays(int $year): array
    {
        // https://en.wikipedia.org/wiki/Public_holidays_in_South_Africa
        // https://www.gov.za/about-sa/public-holidays
        $holidays = [
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'Human Rights Day' => CarbonImmutable::createFromDate($year, 3, 21),
            'Freedom Day' => CarbonImmutable::createFromDate($year, 4, 27),
            "Workers' Day" => CarbonImmutable::createFromDate($year, 5, 1),
            'Youth Day' => CarbonImmutable::createFromDate($year, 6, 16),
            "National Women's Day" => CarbonImmutable::createFromDate($year, 8, 9),
            'Heritage Day' => CarbonImmutable::createFromDate($year, 9, 24),
            'Day of Reconciliation' => CarbonImmutable::createFromDate($year, 12, 16),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Day of Goodwill' => CarbonImmutable::createFromDate($year, 12, 26),
        ];

        $result = [];
        foreach ($holidays as $name => $date) {
            $result[] = Holiday::national($name, $date);

            $observedDay = $this->sundayToNextMonday($date);

            if ($observedDay) {
                $result[] = Holiday::national("{$name} Observed", $observedDay);
            }
        }

        return array_merge($result, $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('Family Day', $easter->addDay()),
        ];
    }
}
