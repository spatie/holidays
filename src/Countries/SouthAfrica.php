<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\HasObservedHolidays;

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

        foreach ($holidays as $name => $date) {
            $observedDay = $this->sundayToNextMonday($date);

            if ($observedDay) {
                $holidays[$name.' Observed'] = $observedDay;
            }
        }

        return array_merge($holidays, $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Good Friday' => $easter->subDays(2),
            'Family Day' => $easter->addDay(),
        ];
    }
}
