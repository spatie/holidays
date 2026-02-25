<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class Canada extends Country
{
    public function countryCode(): string
    {
        return 'ca';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'Canada Day' => CarbonImmutable::createFromDate($year, 7, 1),
            'Civic Holiday' => CarbonImmutable::parse('first monday of August '.$year),
            'Labour Day' => CarbonImmutable::parse('first monday of September '.$year),
            'National Day for Truth and Reconciliation' => CarbonImmutable::createFromDate($year, 9, 30),
            'Remembrance Day' => CarbonImmutable::createFromDate($year, 11, 11),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonInterface> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        // the Monday preceding May 25
        $victoriaDay = CarbonImmutable::createFromDate($year, 5, 25)
            ->previous('Monday');

        return [
            'Victoria Day' => $victoriaDay,
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
            'Thanksgiving' => CarbonImmutable::parse('second monday of October '.$year),
        ];
    }
}
