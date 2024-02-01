<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Kuwait extends Country
{
    public function countryCode(): string
    {
        return 'kw';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'National Day' => '02-25',
            'Liberation Day' => '02-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // If there are any specific variable holidays for Kuwait, you can add them here.
        return [];
    }
}
