<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class SouthAfrica extends Country
{

    public function countryCode(): string
    {
        return 'za';
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        // https://www.gov.za/about-sa/public-holidays
        $standardDates = [
            'New Year\'s Day' => '01-01',
            'Human Rights Day' => '03-21',
            'Freedom Day' => '04-27',
            'Workers\' Day' => '05-01',
            'Youth Day' => '06-16',
            'National Women\'s Day' => '08-09',
            'Heritage Day' => '09-24',
            'Day of Reconciliation' => '12-16',
            'Christmas Day' => '12-25',
            'Day of Goodwill' => '12-26',
        ];

        $observedDates = [];
        foreach ($standardDates as $name => $standardDate) {
            $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$standardDate}");
            if ($date && $date->isSunday()) {
                // Public Holidays that fall on Sundays are observed on the following Monday.
                $observedDates["{$name} Observed"] = $date->addDay();
            }
        }

        return array_merge($standardDates, $observedDates, $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Africa/Johannesburg');

        return [
            'Good Friday' => $easter->subDays(2),
            'Family Day' => $easter->addDay(),
        ];
    }
}
