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
            'New Year\'s Day' => '01-01',
            'Canada Day' => '07-01',
            'Civic Holiday' => 'first monday of August',
            'Labour Day' => 'first monday of September',
            'National Day for Truth and Reconciliation' => '09-30',
            'Remembrance Day' => '11-11',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
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
            'Thanksgiving' => 'second monday of October',
        ];
    }
}
