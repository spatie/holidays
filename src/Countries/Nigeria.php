<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Nigeria extends Country
{
    public function countryCode(): string
    {
        return 'ng';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            "Worker's Day" => CarbonImmutable::createFromDate($year, 5, 1),
            'Democracy Day' => CarbonImmutable::createFromDate($year, 6, 12),
            'Independence Day' => CarbonImmutable::createFromDate($year, 10, 1),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
        ];
    }
}
