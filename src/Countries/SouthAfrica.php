<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

use function in_array;

class SouthAfrica extends Country
{
    public function countryCode(): string
    {
        return 'za';
    }

    protected function allHolidays(int $year): array
    {
        // https://en.wikipedia.org/wiki/Public_holidays_in_South_Africa
        // https://www.gov.za/about-sa/public-holidays
        $holidays = [
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

        foreach ($holidays as $name => $date) {
            $holidayDate = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}");
            assert($holidayDate instanceof CarbonImmutable);

            // The Public Holidays Act (Act No 36 of 1994) states that whenever a public holiday falls on a Sunday, the Monday following it will be a public holiday.
            // https://www.gov.za/documents/public-holidays-act
            if (
                $holidayDate->isSunday() &&
                ! in_array($holidayDate->addDay()->format('m-d'), $holidays, true) // Check that the Monday is not already a holiday
            ) {
                $holidays[$name.' Observed'] = $holidayDate->addDay();
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
