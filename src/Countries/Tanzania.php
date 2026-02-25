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
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'Labor Day' => CarbonImmutable::createFromDate($year, 5, 1),
            'Saba Saba Day' => CarbonImmutable::createFromDate($year, 7, 7),
            'Farmers Day (Nane Nane Day)' => CarbonImmutable::createFromDate($year, 8, 8),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $variable_holidays = [
            'Easter Monday' => $easter->addDay(),
            'Good Friday' => $easter->addDays(-2),
        ];

        // Zanzibar Revolutionary Day celebrations started in 1964
        if ($year >= 1964) {
            $variable_holidays['Zanzibar Revolutionary Day'] = CarbonImmutable::createFromDate($year, 1, 12);
        }

        // Karume Day celebrations started in 1973
        if ($year >= 1973) {
            $variable_holidays['Karume Day'] = CarbonImmutable::createFromDate($year, 4, 7);
        }

        //  'Union Day celebrations started in 1964
        if ($year >= 1964) {
            $variable_holidays['Union Day'] = CarbonImmutable::createFromDate($year, 4, 26);
        }

        // Nyerere Day day celebrations started in 2000
        if ($year >= 2000) {
            $variable_holidays['Nyerere Day'] = CarbonImmutable::createFromDate($year, 10, 14);
        }

        // Independence Day celebrations started in 1961
        if ($year >= 1961) {
            $variable_holidays['Independence Day'] = CarbonImmutable::createFromDate($year, 12, 9);
        }

        return $variable_holidays;
    }
}
