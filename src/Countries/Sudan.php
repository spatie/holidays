<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Sudan extends Country
{
    public function countryCode(): string
    {
        return 'sd';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "New Year's  Day" => '01-01',
            'Independence Day' => '01-01',
            'Labour Day' => '05-01',
            'Christmas Day' => '12-25'
        ], $this->variableHolidays($year));
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    private function variableHolidays(int $year): array
    {
        return [];
    }
}