<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Countries\Country;

class India extends Country
{

    public function countryCode(): string
    {
        return 'in';
    }

    /**
     * Reference
     * @link https://en.wikipedia.org/wiki/Public_holidays_in_India
     */
    protected function allHolidays(int $year): array
    {
        return array_merge(
            # These are pretty well fixed holidays
            [
                'Republic Day' => '01-26',
                'Labour Day' => '05-01',
                'Independence Day' => '08-15',
                'Gandhi Jayanti' => '10-02',
                'Christmas' => '12-25',
            ],
            $this->variableHolidays($year)
        );
    }

    /**
     * TODO: Add variable holidays
     * In India there are more state specific holidays in compared to National Holidays
     * We can implement a mechanism to check the state and return the holidays accordingly
     */
    protected function variableHolidays(int $year): array
    {
        return [];
    }
}
