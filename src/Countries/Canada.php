<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class Canada extends Country
{
    public function countryCode(): string
    {
        return 'ca';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national('Canada Day', "{$year}-07-01"),
            Holiday::national('Civic Holiday', CarbonImmutable::parse("first monday of August {$year}")),
            Holiday::national('Labour Day', CarbonImmutable::parse("first monday of September {$year}")),
            Holiday::national('National Day for Truth and Reconciliation', "{$year}-09-30"),
            Holiday::national('Remembrance Day', "{$year}-11-11"),
            Holiday::national('Christmas Day', "{$year}-12-25"),
            Holiday::national('Boxing Day', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        // the Monday preceding May 25
        $victoriaDay = CarbonImmutable::createFromDate($year, 5, 25)
            ->previous('Monday')->toImmutable();

        return [
            Holiday::national('Victoria Day', $victoriaDay),
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('Easter Monday', $easter->addDay()),
            Holiday::national('Thanksgiving', CarbonImmutable::parse("second monday of October {$year}")),
        ];
    }
}
