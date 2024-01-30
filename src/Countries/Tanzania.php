<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Tanzania extends Country
{
    public function countryCode(): string
    {
        return 'tz';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Labor Day' => '05-01',
            'Saba Saba Day' => '07-07',
            'Farmers Day (Nane Nane Day)' => '08-08',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $variable_holidays = [
            'Easter Monday' => $easter->addDay(),
            'Good Friday' => $easter->addDays(-2),
        ];

        // Zanzibar Revolutionary Day celebrations started in 1964
        if ($year >= 1964) {
            $variable_holidays['Zanzibar Revolutionary Day'] = '01-12';
        }

        // Karume Day celebrations started in 1973
        if ($year >= 1973) {
            $variable_holidays['Karume Day'] = '04-07';
        }

        //  'Union Day celebrations started in 1964
        if ($year >= 1964) {
            $variable_holidays['Union Day'] = '04-26';
        }

        // Nyerere Day day celebrations started in 2000
        if ($year >= 2000) {
            $variable_holidays['Nyerere Day'] = '10-14';
        }

        // Independence Day celebrations started in 1961
        if ($year >= 1961) {
            $variable_holidays['Independence Day'] = '12-09';
        }

        return $variable_holidays;
    }
}
