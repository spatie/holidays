<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;


class Bahrain extends Country
{
    public function countryCode(): string
    {
        return 'bh';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year Day' => '1-1',
            'Labour Day' => '5-1',
            'National Day' => '12-16',
            'National Day Holiday' => '12-17',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [];
    }
}
