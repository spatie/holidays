<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Tanzania extends Country
{
    public function countryCode(): string
    {
        return 'tz';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national('Labor Day', "{$year}-05-01"),
            Holiday::national('Saba Saba Day', "{$year}-07-07"),
            Holiday::national('Farmers Day (Nane Nane Day)', "{$year}-08-08"),
            Holiday::national('Christmas Day', "{$year}-12-25"),
            Holiday::national('Boxing Day', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $holidays = [
            Holiday::national('Easter Monday', $easter->addDay()),
            Holiday::national('Good Friday', $easter->addDays(-2)),
        ];

        if ($year >= 1964) {
            $holidays[] = Holiday::national('Zanzibar Revolutionary Day', "{$year}-01-12");
        }

        if ($year >= 1973) {
            $holidays[] = Holiday::national('Karume Day', "{$year}-04-07");
        }

        if ($year >= 1964) {
            $holidays[] = Holiday::national('Union Day', "{$year}-04-26");
        }

        if ($year >= 2000) {
            $holidays[] = Holiday::national('Nyerere Day', "{$year}-10-14");
        }

        if ($year >= 1961) {
            $holidays[] = Holiday::national('Independence Day', "{$year}-12-09");
        }

        return $holidays;
    }
}
